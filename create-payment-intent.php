<?php
require 'vendor/autoload.php';
// Secret Key
\Stripe\Stripe::setApiKey('sk_test_51L5k1VSB2OlEnbVR1mF5ICQiD8knkVclE3lhD57oHuvZY5QMYxTBDF1Wol8HcRwbiBFBt41SkQ4gwQuPzd6XoOwT00PC5Xp9ym');

$input = json_decode(file_get_contents('php://input'), true);
$name = $input['name'];
$username = $input['username'];
$email = $input['email'];
$amount = (int) $input['amount'] * 100;
$address = $input['address'];
$city = $input['city'];
$postal_code = $input['postal_code'];
$state = $input['state'];
$country = $input['country'];

try {
    //Check if a customer with the given email already exists
    $existingCustomer = \Stripe\Customer::all([
        'email' => $email,
        'limit' => 1,
    ]);

    if (count($existingCustomer->data) > 0) {
        $customer = $existingCustomer->data[0];
    } else {
        // Create a new customer if no match is found
        $customer = \Stripe\Customer::create([
            'name' => $name,
            'email' => $email,
            'metadata' => [
                'username' => $username,
            ],
            'address' => [
                'line1' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'state' => $state,
                'country' => $country,
            ]
        ]);
    }

    //Create Payment Intent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'customer' => $customer->id,
        'description' => 'Payment for user ' . $username,
        'setup_future_usage' => 'off_session',
        'automatic_payment_methods' => ['enabled' => true],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
