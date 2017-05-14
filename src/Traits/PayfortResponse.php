<?php

namespace LaravelPayfort\Traits;

use Illuminate\Http\Request;


trait PayfortResponse
{
    /**
     * Handle Payfort feedback
     *
     * @param \Illuminate\Http\Request $request
     * @return array $feedback_parameters
     */
    public function handlePayfortFeedback(Request $request)
    {
        return $request->all();
    }

    /**
     * Handle Payfort callback (from redirection page)
     *
     * @param \Illuminate\Http\Request $request
     * @return array $callback_parameters
     * @see https://docs.payfort.com/docs/redirection/build/index.html#authorization-purchase-response
     */
    public function handlePayfortCallback(Request $request)
    {
        return $request->all();
    }
}