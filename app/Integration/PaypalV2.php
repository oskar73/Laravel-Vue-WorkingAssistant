<?php

namespace App\Integration;

class PaypalV2
{
    public $accessToken;
    private $clientId;
    private $clientSecret;
    private $apiEndpoint;
    private $partnerId;

    public function __construct()
    {
        $paypal = primary_option('paypal', null);
        $this->clientId = optional($paypal)['client_id'];
        $this->clientSecret = optional($paypal)['client_secret'];
        $this->partnerId = optional($paypal)['partner_id'];

        if (optional($paypal)['sandbox'] == 'live') {
            $this->apiEndpoint = 'https://api-m.paypal.com';
        } else {
            $this->apiEndpoint = 'https://api-m.sandbox.paypal.com';
        }
        if (is_null($this->accessToken)) {
            $this->accessToken = $this->getAccessToken();
        }
    }

    public function createOrder($order) {
        $accessToken = $this->accessToken;
        $apiEndpoint = $this->apiEndpoint . '/v2/checkout/orders';

        $headers = [
            'Content-Type: application/json',
            'PayPal-Request-Id: ' . $order['order_id'],
            'Authorization: Bearer ' . $accessToken,
        ];

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'payee' =>  [
                        'merchant_id' =>  $order['payee_merchant_id']
                    ],
                    'custom_id' =>  $order['order_id'],
                    'items' =>  $order['items'],
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $order['total'],
                        'breakdown' =>  [
                            'item_total'    =>  [
                                'currency_code' => 'USD',
                                'value' =>  $order['total']]
                        ]
                    ],
                    "payment_instruction"   =>  [
                        "disbursement_mode" =>  "INSTANT",
                        // "platform_fees" => [
                        //     [
                        //         "amount" =>  [
                        //             "currency_code" =>  "USD",
                        //             "value" =>  "2.00"
                        //         ]
                        //     ]
                        // ]
                    ]
                ],
            ],
            'payment_source' => [
                'paypal' => [
                    'experience_context' => [
                        'payment_method_preference' => 'IMMEDIATE_PAYMENT_REQUIRED',
                        'locale' => 'en-US',
                        'landing_page' => 'LOGIN',
                        'user_action' => 'PAY_NOW',
                        'return_url' => $order['url'] . '/success?method=paypal',
                        'cancel_url' => $order['url'] . '/failed',
                    ],
                ],
            ],
        ];

        $ch = curl_init($apiEndpoint);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData;
    }

    public function sellerOnboardingStatus($sellerId) {
        $url = $this->apiEndpoint . '/v1/customer/partners/' . $this->partnerId . '/merchant-integrations/' . $sellerId;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        return $data;
    }

    public function getOnboardingSignupLink($paymentType = "EXPRESS_CHECKOUT")
    {
        $url = $this->apiEndpoint.'/v2/customer/partner-referrals';

        // Prepare the request data as an associative array
        $requestData = [
            "user_id" => user()->id,
            "operations" => [
                [
                    "operation" => "API_INTEGRATION",
                    "api_integration_preference" => [
                        "rest_api_integration" => [
                            "integration_method" => "PAYPAL",
                            "integration_type" => "THIRD_PARTY",
                            "third_party_details" => [
                                "features" => ["PAYMENT", "REFUND"]
                            ]
                        ]
                    ]
                ]
            ],
            "products" => [$paymentType],
            "legal_consents" => [
                [
                    "type" => "SHARE_DATA_CONSENT",
                    "granted" => true
                ]
            ],
            "partner_config_override" => [
                "return_url" => route('admin.ecommerce.setting.account.paypal.connect')
            ]
        ];

        // Convert the request data to JSON format
        $jsonData = json_encode($requestData);

        // Prepare cURL options
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken,
        ]);

        // Execute the cURL request
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        return $data;
    }

    public function getAccessToken()
    {
        // Prepare cURL options
        $ch = curl_init($this->apiEndpoint.'/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ':' . $this->clientSecret);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        // Execute the cURL request
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        if (isset($data['access_token'])) {
            return $data['access_token'];
        } else {
            throw new \Exception('Unable to retrieve access token: ' . json_encode($data));
        }
    }
}
