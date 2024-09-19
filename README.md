Stripe Payment Integration

This project demonstrates how to integrate Stripe's Payment Intent API with a PHP backend and an HTML form, allowing users to make payments and store customer information.

Prerequisites
- PHP 7.x or higher
- Composer for managing dependencies
- Stripe account
- Stripe CLI for testing webhooks (optional)

Installation
1. Clone the repository or download the source code.
2. Navigate to the project directory and install the required dependencies using Composer:
    composer require stripe/stripe-php

3. Replace the placeholder API keys (sk_test_XXXX and pk_test_XXXX) with your Stripe secret and publishable keys in create-payment-intent.php and index.html, respectively.

- Secret Key: This is used on the server side to securely manage customer details and payments.
- Publishable Key: This is used on the client side to tokenize payment information.
4. Ensure your web server can execute PHP and serves your files from a public directory (e.g., using Apache, Nginx, or built-in PHP server).

File Structure

/root
│── vendor/                       # Composer dependencies
│── create-payment-intent.php     # Server-side code to create payment intent
│── index.html                    # HTML form for collecting payment details
└── README.md                     # Documentation


Server-side (PHP)
- File: create-payment-intent.php
- Purpose: Creates a Payment Intent in Stripe, checks if a customer with the same email already exists, and if not, creates a new customer.

Process

1. Stripe PHP SDK: Imported using Composer's autoloader.
2. Customer Check: Uses \Stripe\Customer::all() to check if a customer with the provided email already exists. If a match is found, it retrieves the customer; otherwise, it creates a new customer with the provided name, email, and address details.
3. Payment Intent Creation: Uses \Stripe\PaymentIntent::create() to initiate a payment with the provided amount, currency, and customer ID.
4. Error Handling: Any Stripe API errors are caught and returned in JSON format.

Example Endpoint Usage

POST /stripe/create-payment-intent.php
{
    "name": "John Doe",
    "username": "johndoe",
    "email": "john@example.com",
    "amount": 100,
    "address": "123 Main St",
    "city": "New York",
    "postal_code": "10001",
    "state": "NY",
    "country": "US"
}

Client-side (HTML & JavaScript)
- File: index.html
- Purpose: Collects customer payment details and securely sends them to Stripe using the Stripe.js library.

Process

1. Stripe.js: Initializes Stripe using the publishable key and creates a card element for securely collecting payment card details.
2. Form Submission: When the form is submitted, it collects the customer's name, email, address, and payment information.
3. Payment Intent: The form submission triggers a request to create-payment-intent.php, sending customer data to the server. Upon receiving a client secret, Stripe.js confirms the payment.
4. Error Handling: If the payment fails, an error message is displayed; otherwise, a success message appears.

How to Use

1. Open the index.html file in your browser.
2. Fill out the form with the necessary payment details.
3. Submit the form, and the system will either:
    - Create a new customer and payment intent or retrieve an existing customer.
    - Process the payment and show success/failure messages.

Notes

- Ensure that your PHP server supports HTTPS if you're deploying to production, as Stripe requires secure connections for handling sensitive payment information.
- Replace the Stripe keys (sk_test and pk_test) with your production keys when you go live.


