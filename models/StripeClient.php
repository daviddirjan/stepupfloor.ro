<?php

class StripeClient
{
    private static function request(string $method, string $endpoint, array $params = []): array
    {
        $ch = curl_init('https://api.stripe.com/v1' . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => SettingsModel::get('stripe_secret_key') . ':',
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_TIMEOUT        => 30,
        ]);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        $raw  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException('Stripe API connection error');
        }
        $data = json_decode($raw, true) ?? [];
        if ($code >= 400) {
            throw new RuntimeException($data['error']['message'] ?? 'Stripe API error ' . $code);
        }
        return $data;
    }

    public static function createPaymentIntent(int $amountSmallest, string $currency = 'ron'): array
    {
        return self::request('POST', '/payment_intents', [
            'amount'                              => $amountSmallest,
            'currency'                            => $currency,
            'automatic_payment_methods[enabled]'  => 'true',
        ]);
    }

    public static function verifyWebhookSignature(string $payload, string $sigHeader): array
    {
        $parts = [];
        foreach (explode(',', $sigHeader) as $chunk) {
            [$k, $v] = array_pad(explode('=', $chunk, 2), 2, '');
            $parts[trim($k)][] = trim($v);
        }
        $timestamp = $parts['t'][0] ?? 0;
        $expected  = hash_hmac('sha256', $timestamp . '.' . $payload, SettingsModel::get('stripe_webhook_secret'));
        $valid = false;
        foreach ($parts['v1'] ?? [] as $sig) {
            if (hash_equals($expected, $sig)) {
                $valid = true;
                break;
            }
        }
        if (!$valid) {
            throw new RuntimeException('Invalid Stripe webhook signature');
        }
        return json_decode($payload, true) ?? [];
    }
}
