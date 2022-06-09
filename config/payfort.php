<?php
return [
    /**
     * Defines wether to activate the Payfort sandbox enviroment or not.
     */
    'sandbox' => env('PAYFORT_USE_SANDBOX', false),

    /**
     * The Payfort merchant account identifier.
     */
    'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER'),

    /**
     * The Payfort account access code.
     */
    'access_code' => env('PAYFORT_ACCESS_CODE'),

    /**
     * The Payfort account sha type (sha256/sha512).
     */
    'sha_type' => env('PAYFORT_SHA_TYPE', 'sha256'),

    /**
     * The Payfort account sha request phrase.
     */
    'sha_request_phrase' => env('PAYFORT_SHA_REQUEST_PHRASE'),

    /**
     * The Payfort account sha response phrase.
     */
    'sha_response_phrase' => env('PAYFORT_SHA_RESPONSE_PHRASE'),

    /**
     * The default currency for you app. Currency ISO code 3.
     */
    'currency' => env('PAYFORT_CURRENCY', 'USD'),

    /**
     * The URL to return after submitting Payfort forms.
     */
    'return_url' => env('PAYFORT_RETURN_URL', '/')
];