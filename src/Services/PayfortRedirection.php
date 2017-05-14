<?php

namespace LaravelPayfort\Services;

use LaravelPayfort\Traits\PayfortRedirectRequest;


class PayfortRedirection extends Payfort
{

    use PayfortRedirectRequest;

    /**
     * Payfort API Processor Constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        # Call parent constructor to initialize common settings
        parent::__construct($config);

        $this->payfortEndpoint = 'https://checkout.payfort.com/FortAPI/paymentPage';

        # Check if it is sandbox environment to make requests to Payfort sandbox url.
        if (data_get($this->config, 'sandbox', false)) {
            $this->payfortEndpoint = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
        }

        $this->config['return_url'] = url($this->config['return_url']);
    }
}