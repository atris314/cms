<?php

namespace App\Transformers;

use Carbon\Carbon;

class FailedPaymentView
{
    /**
     * @param $payment
     * @return array[]
     */
    public static function transform($payment): array
    {
        $params = $payment->request;

        $header = [
            'Content-Type' => 'application/json',
            "X-API-KEY" => $payment->mask_api_key,
            'X-SANDBOX' => (int)$params->sandbox
        ];

//        $created = jdate('Y-m-d H:i:s', Carbon::parse($payment['created_at'])->timestamp);
        $created = Carbon::parse($payment['created_at']);
        return [
            'view' => [
                'request' => json_encode([
                    'url' => "Post: ".env('IDPAY_ENDPOINT','https://api.idpay.ir/v1.1')."/payment",
                    'header' => $header,
                    'params' => self::params($params)
                ]),
                'response' => $payment['response'],
                'step_time' => $created,
                'request_time' => $payment['request_time'],
            ],

        ];

    }

    /**
     * @param $params
     * @return array
     */
    protected static function params($params): array
    {
        return [
            "order_id" => $params->order_id,
            "amount" => $params->amount,
            "name" => $params->name,
            "phone" => $params->phone,
            "mail" => $params->mail,
            "desc" => $params->desc,
            "callback" => $params->callback,
            "reseller" => $params->reseller,
        ];
    }
}
