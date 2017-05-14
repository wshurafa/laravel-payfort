<?php

namespace LaravelPayfort\Services;


abstract class Payfort
{

    /**
     * Configurations array
     *
     * @var array
     */
    protected $config;

    /**
     * Payfort endpoint
     *
     * @var string
     */
    protected $payfortEndpoint;

    /**
     * Payfort Processor Constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->setPayfortConfig($config);
    }

    /**
     * Function to set payfort API Configuration.
     *
     * @param array $config Package configuration array
     *
     * @return void
     */
    protected function setPayfortConfig($config)
    {
        $this->config = $config;

        if (!isset($config['language'])) {
            $this->config['language'] = app()->getLocale() == 'ar' ? 'ar' : 'en';
        }
    }

    /**
     * Function to get amount according to its currency allowed decimals
     *
     * @param float $amount The amount
     * @param string $currency The currency
     *
     * @return integer Payfort amount
     */
    public function getPayfortAmount($amount, $currency)
    {
        $decimals = data_get(array(
            'BHD' => 3,
            'IQD' => 3,
            'JOD' => 3,
            'KWD' => 3,
            'LYD' => 3,
            'OMR' => 3,
            'TND' => 3
        ), $currency, 2);

        return intval($amount * pow(10, $decimals));
    }

    /**
     * Function to calc payfort request/response signature following payfort documentation
     *
     * @see https://docs.payfort.com/docs/in-common/build/index.html#signature
     *
     * @param array $params
     * @param string $signature_type
     *
     * @return string
     */
    public function calcPayfortSignature(array $params, $signature_type = 'request')
    {
        # Steps as listed in payfort documentation
        # 1
        ksort($params);
        # 2
        $combined_params = array_map(function ($k, $v) {
            return $k == 'signature' ? '' : "$k=$v";
        }, array_keys($params), array_values($params));
        # 3
        $joined_parameters = join('', $combined_params);
        # 4
        $salt = data_get($this->config, ($signature_type == 'response' ? 'sha_response_phrase' : 'sha_request_phrase'));
        $signature = sprintf('%s%s%s', $salt, $joined_parameters, $salt);
        # 5
        $signature = hash($this->config['sha_type'], $signature);

        return $signature;
    }
}