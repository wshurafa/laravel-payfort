<?php
use LaravelPayfort\Facades\Payfort;


class APIRequestsTest extends TestCase
{

    /**
     * Testing create SDK_TOKEN service
     *
     * @return void
     */
    public function testCreateMobileSDKToken()
    {
        $sdk_token = Payfort::api()->createMobileSDKToken(str_random(40));

        $this->assertNotEmpty($sdk_token);
    }

    /**
     * Testing checking order status by fort id
     *
     * @return void
     * @expectedException \LaravelPayfort\Exceptions\PayfortRequestException
     */
    public function testCheckOrderStatusByFortId()
    {
        $random_fort_id = rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999);

        Payfort::api()->checkOrderStatusByFortId($random_fort_id);
    }

}