<?php

namespace App\Transformers;

use App\Models\Activity;
use App\Models\Payment;
use Carbon\Carbon;

class VerifyTransformer
{
    /**
     * A Fractal transformer.
     *
     * @param Payment $payment
     * @return array
     */
    public static function transform(Payment $payment): array
    {
        $params = $payment->request;

        $header = [
            'Content-Type' => 'application/json',
            "X-API-KEY" => $payment->mask_api_key,
            'X-SANDBOX' => (int)$params->sandbox
        ];

        $created_at = $payment['created_at'] ?? now()->format('Y-m-d H:i:s');

        return [
            'view' => [
                'request' => json_encode([
                    'url' => 'Post: ' . env('IDPAY_ENDPOINT', 'https://api.idpay.ir/v1.1') . '/payment/verify',
                    'header' => $header,
                    'params' => self::params($params)
                ]),
                'response' => $payment['response'],
                'step_time' => jdate('Y-m-d H:i:s', Carbon::parse($created_at)->timestamp),
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
            'id' => $params->id,
            'order_id' => $params->order_id,
        ];
    }
}
