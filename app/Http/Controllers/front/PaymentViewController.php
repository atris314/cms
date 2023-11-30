<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Transformers\PaymentView;
use App\Transformers\CallBackResultArray;
use App\Transformers\VerifyTransformer;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class PaymentViewController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('paymentOrder.index')->with([
            'paymentAnswerHtml' => '',
        ]);
    }

    /**
     * @param $activityCreateArray
     * @param $httpCode
     * @return array|string
     * @throws Throwable
     */
    public function paymentAnswer($paymentCreateArray, $httpCode)
    {
        return view('partial.paymentAnswer')->with([
            'payment' => $paymentCreateArray['view'],
            'http_code' => $httpCode,
        ])->render();
    }

    /**
     * @param $link
     * @param $uuid
     * @return array|string
     * @throws Throwable
     */
    public function transferToGateway($link, $uuid)
    {
        return view('partial.transferToPort')->with([
            'link' => $link,
            'order_uuid' => $uuid,
        ])->render();
    }

    /**
     * @param $link
     * @param $stepTime
     * @return array|string
     * @throws Throwable
     */
    public function callBack($link, $stepTime)
    {
        return view('partial.callback')->with([
            'url' => $link,
            'step_date' => Verta::instance($stepTime->timestamp)->format('%B %d، %Y'),
        ])->render();
    }

    /**
     * @param $callbackResult
     * @param $stepTime
     * @return array|string
     * @throws Throwable
     */
    public function callBackResult($callbackResult, $stepTime)
    {
        return view('partial.callbackResult')->with(
            [
                'callbackResult' => $callbackResult,
                'step_tome' =>Verta::instance($stepTime->timestamp)->format('%B %d، %Y'),
                'url' => route('callback'),
            ]
        )->render();
    }

    /**
     * @param $response
     * @param $request
     * @param $httpCode
     * @param $stepTime
     * @param $request_time
     * @return array|string
     */
    public function verifyResult($response, $request, $httpCode, $stepTime, $request_time)
    {
        return view('partial.verifyResult')->with([
            'response' => $response,
            'request' => $request,
            'http_code' => $httpCode,
            'step_time' => $stepTime,
            'request_time' => $request_time,
        ])->render();
    }

    /**
     * @param Order $order
     * @return Application|Factory|View|void
     * @throws Throwable
     */
    public function show(Order $order)
    {

        $callbackResultHtml = null;
        $verifyResultHtml = null;
        $verifyRequestHtml = null;

        $paymentCreate = $order->payments->where('step', 'create')->last();
        $redirectResult = $order->payments->where('step', 'redirect')->last();
        $callbackResult = $order->payments->where('step', 'return')->last();
        $verifyResult = $order->payments->where('step', 'verify')->last();
        if (empty($paymentCreate) || empty($redirectResult)) {
            return abort(404);
        }

        $paymentCreateArray = PaymentView::transform($paymentCreate);

        $paymentAnswerHtml = $this->paymentAnswer($paymentCreateArray, $paymentCreate->http_code);
        $transferToPortHtml = $this->transferToGateway(json_decode($paymentCreateArray['view']['response'])->link, $order->uuid);
        $callbackHtml = $this->callBack(json_decode($paymentCreateArray['view']['response'])->link, $redirectResult->created_at);
        if (!empty($callbackResult)) {
            $status = json_decode($order->payments->where('step', 'return')->last()->response)->status;

            if ((int)$status !== 10) {
                $this->get_status_description($status);
                $replaced = Str::replaceLast('استاتوس', $status, "جمله (وضعیت: استاتوس)");
                $replaced = Str::replaceLast('جمله', $this->msg, $replaced);
                Session::flash('status', $replaced);
                toastr()->error($replaced);
            }

            $callbackResultArray = CallBackResultArray::transform($callbackResult->response);
            $callbackResultHtml = $this->callBackResult($callbackResultArray, $callbackResult->created_at);

            $verifyRequestHtml = view('partial.verifyRequest')->with(['order_uuid' => $order->uuid])->render();

            if (!empty($verifyResult)) {
                $verifyResultArray = VerifyTransformer::transform($verifyResult);
                $verifyResultHtml = $this->verifyResult($verifyResultArray['view']['response'], $verifyResultArray['view']['request'], $verifyResult->http_code, $verifyResultArray['view']['step_time'], $verifyResultArray['view']['request_time']);
            }
        }

        return view('front.dashboard.purchase.result')->with([
            'order' => $order,
            'paymentAnswerHtml' => $paymentAnswerHtml,
            'transferToPortHtml' => $transferToPortHtml,
            'callbackHtml' => $callbackHtml,
            'callbackResultHtml' => $callbackResultHtml,
            'verifyRequestHtml' => $verifyRequestHtml,
            'verifyResultHtml' => $verifyResultHtml,
        ]);
    }
    public function get_status_description($status)
    {
        switch ($status) {
            case 1:
                $this->msg = 'پرداخت انجام نشده است.  ';
                break;
            case 2:
                $this->msg = 'پرداخت ناموفق بوده است.';
                break;
            case 3:
                $this->msg = 'خطا رخ داده است.';
                break;
            case 4:
                $this->msg = 'بلوکه شده.';
                break;
            case 5:
                $this->msg = 'برگشت به پرداخت کننده.';
                break;
            case 6:
                $this->msg = 'برگشت خورده سیستمی.';
                break;
            case 7:
                $this->msg = 'انصراف از پرداخت.';
                break;
            case 8:
                $this->msg = 'به درگاه پرداخت منتقل شد.';
                break;
            case 10:
                $this->msg = 'در انتظار تایید پرداخت.';
                break;
            case 100:
                $this->msg = 'پرداخت تایید شده است.';
                break;
            case 101:
                $this->msg = 'پرداخت قبلا تایید شده است.';
                break;

            case 200:
                $this->msg = 'به دریافت کننده واریز شد.';
                break;
            case 405:
                $this->msg = 'تایید پرداخت امکان پذیر نیست.';
                break;
        }

    }
}
