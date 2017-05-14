<?php

namespace LaravelPayfort\Traits;


trait PayfortRedirectRequest
{

    /**
     * Display payfort payment page to tokenize customer credit card info
     *
     * @see https://docs.payfort.com/docs/merchant-page/build/index.html#parameters-submission-type
     *
     * @param array $data
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function displayTokenizationPage($data)
    {
        # Prepare redirection page request parameters
        $requestParams = [
            'service_command' => 'TOKENIZATION',
            'access_code' => $this->config['access_code'],
            'merchant_identifier' => $this->config['merchant_identifier'],
            'merchant_reference' => $data['merchant_reference'],
            'language' => $this->config['language'],
            'return_url' => $this->config['return_url']
        ];

        return $this->displayPayfortPage($requestParams);
    }

    /**
     * Display payfort payment page to Authorize/Purchase an amount
     *
     * @see https://docs.payfort.com/docs/merchant-page/build/index.html#merchant-page-operations
     *
     * @param array $data
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function displayRedirectionPage($data)
    {
        # Prepare redirection page request parameters
        $requestParams = [
            'command' => data_get($data, 'command', 'AUTHORIZATION'),
            'access_code' => $this->config['access_code'],
            'merchant_identifier' => $this->config['merchant_identifier'],
            'merchant_reference' => $data['merchant_reference'],
            'amount' => $this->getPayfortAmount($data['amount'], $data['currency']),
            'currency' => data_get($data, 'currency', $this->config['currency']),
            'language' => $this->config['language'],
            'customer_email' => $data['customer_email'],
            'return_url' => $this->config['return_url']
        ];

        # Redirection page request optional parameters
        $requestOptionalParameters = [
            'token_name',
            'payment_option',
            'sadad_olp',
            'eci',
            'order_description',
            'customer_ip',
            'customer_name',
            'merchant_extra',
            'merchant_extra1',
            'merchant_extra2',
            'merchant_extra3'
        ];

        # Check for request optional parameters in passed params
        foreach ($requestOptionalParameters as $optionalParameter) {
            if (array_key_exists($optionalParameter, $data)) {
                $requestParams[$optionalParameter] = $data[$optionalParameter];
            }
        }

        return $this->displayPayfortPage($requestParams);
    }


    /**
     * Display payfort redirection page
     *
     * @param array $requestParams
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function displayPayfortPage($requestParams)
    {
        # Payfort redirect url
        $redirectUrl = $this->payfortEndpoint;

        # Add signature parameter
        $requestParams['signature'] = $this->calcPayfortSignature($requestParams, 'request');

        return view('laravel-payfort::merchant-page', compact('requestParams', 'redirectUrl'));
    }

}