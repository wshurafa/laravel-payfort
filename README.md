Laravel Payfort Package
=======================
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)


`Laravel Payfort` provides a simple and rich way to perform and handle operations for 
`Payfort` (MEA based online payment gateway) check here to read more <a href="http://www.payfort.com/">Payfort</a>.  
This package supports a set of `Payfort` operations as listed below, other operations are open for future work and 
contribution. 

* AUTHORIZATION/PURCHASE
* TOKENIZATION
* SDK_TOKEN
* CHECK_STATUS

You have to read the `Payfort` documentation very well before proceeding in using any package, the package author 
will not write about `Payfort` operations, what and how to use.

## Installation

You can install the package via composer:
```bash
composer require wshurafa/laravel-payfort
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider "LaravelPayfort\Providers\PayfortServiceProvider"
```
This is the contents of the file that will be published at `config/payfort.php` :

```php
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
 ```

### Then you have to add the following constants in the `.env` file:

```bash
PAYFORT_USE_SANDBOX=true                      # Defines wether to activate the payfort sandbox enviroment or not.
PAYFORT_MERCHANT_IDENTIFIER=s2b3rj1vrjrhc1x   # The payfort merchant account identifier
PAYFORT_ACCESS_CODE=s31bpM1ebfNnwqo           # The payfort account access code
PAYFORT_SHA_TYPE=sha256                       # The payfort account sha type. sha256/sha512
PAYFORT_SHA_REQUEST_PHRASE=keljhgiergh        # The payfort account sha request phrase
PAYFORT_SHA_RESPONSE_PHRASE=lkejgoegj         # The payfort account sha response phrase
PAYFORT_CURRENCY=USD                          # The default currency for you app. Currency ISO code 3.
PAYFORT_RETURN_URL=/payfort/handle            # The url to return after submitting payfort forms.
```

You can find most of these values in your `Payfort` account


## Usage

Once all configuration steps are done, you are ready to use payfort operations in your app. Here is some examples on 
how to use this package:
 
 
### Authorization/Purchase request (Redirection)

To display payfort authorization or purchase page, in your controller's method add the following code snippet:
```php
return Payfort::redirection()->displayRedirectionPage([
    'command' => 'AUTHORIZATION',              # AUTHORIZATION/PURCHASE according to your operation.
    'merchant_reference' => 'ORDR.34562134',   # You reference id for this operation (Order id for example).
    'amount' => 100,                           # The operation amount.
    'currency' => 'QAR',                       # Optional if you need to use another currenct than set in config.
    'customer_email' => 'example@example.com'  # Customer email.
]); 
```
Other optional parameters that can be passed to `displayRedirectionPage` method as follows:
* `token_name`
* `payment_option`
* `sadad_olp`
* `eci`
* `order_description`
* `customer_ip`
* `customer_name`
* `merchant_extra`
* `merchant_extra1`
* `merchant_extra2`
* `merchant_extra3`

`Payfort` page will be displayed and once user submits the payment form, the return url defined in the environment configurations will be called.

See [`Payfort` documentation](https://docs.payfort.com/docs/redirection/build/index.html#authorization-purchase-request) for more info.

### Tokenization request

To display payfort tokenization page, in your controller's method add the following code snippet:
```php
return Payfort::redirection()->displayTokenizationPage([
    'merchant_reference' => 'ORDR.34562134',   # You reference id for this operation (Order id for example).
]); 
```

`Payfort` page will be displayed and once user submits the payment form, the return url defined in the config file 
will be called.

See [`Payfort` documentation](https://docs.payfort.com/docs/other-payfort-services/build/index.html#fort-tokenization-service) for more info.

### Handling Payfort Authorization/Purchase response

#### Handling callback (return)

In your handling controller that handle the return url, you can simply use the `PayfortResponse` trait as follows:
```
use LaravelPayfort\Traits\PayfortResponse as PayfortResponse;

class PayfortOrdersController extends Controller{
    use PayfortResponse;
    
    public function processReturn(Request $request){
        $payfort_return = $this->handlePayfortCallback($request);
        # Here you can process the response and make your decision.
        # The response structure is as described in payfort documentation
    }
}
```

See [`Payfort` documentation](https://docs.payfort.com/docs/redirection/build/index.html#authorization-purchase-response) for more info.


#### Handling Direct Transaction Feedback

Same as handling payfort response except that you have to call `handlePayfortFeedback` instead of `handlePayfortCallback` 


### Localization

The redirect page can be translated by simply using the json file of the language wihtin the `lang` directory of your app.

For example, `ar.json` file:
```
{
    ...
    "Payment redirect page": "صفحة إعادة توجيه الدفع",
    "Click here to proceed to payment if you are not automatically redirected": "انقر هنا لمتابعة الدفع إذا لم تتم إعادة توجيهك تلقائيًا",
    ...
}
```

## Contribution
 Want to improve this package or found a bug ?. Open an issue or do this contribution by yourself and get this honor.

Simply, fork => do you work => make pull request.

Write clear comments and description ;-).


## License
 
`Laravel Payfort` is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
