<?php

namespace DummyVpos\Http;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;

class DummyVposController extends Controller
{
    /**
     * Show confirmation page
     */
    public function showConfirmation(Request $request): View
    {
        if ($request->get('successCallback') && $request->get('errorCallback') && $request->get('price')) {
            $countDown = (int)config('dummy-vpos.confirmation_delay', 30) ?: 30;

            return view('dummy-vpos::pages.confirmation', compact('countDown'));
        }

        return view('dummy-vpos::pages.invalid-callback');
    }

    /**
     * Validate password
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkConfirmation(Request $request): JsonResponse
    {
        $password = $request->input('password');
        $callback = null;

        $validation = $password == config('dummy-vpos.password');
        $params = $request->except(['successCallback', 'errorCallback', 'password']);

        if ($validation) {
            $callback = $request->get('successCallback');

            $params[config('dummy-vpos.success_message_key', 'status')] = config('dummy-vpos.success_message', 'success_message');
            $params[config('dummy-vpos.success_status_key', 'status')] = config('dummy-vpos.success_status_code', 1);
        } else {
            $callback = $request->get('errorCallback');

            $failMessage = config('dummy-vpos.error_password_message', 'error_password');

            if ($password == 'timeout') {
                $failMessage = config('dummy-vpos.error_timeout_message', 'error_timeout');
            } else if ($password == 'canceled') {
                $failMessage = config('dummy-vpos.error_canceled_message', 'error_canceled');
            }

            if ($failMessage) {
                $params[config('dummy-vpos.error_message_key', 'error')] = $failMessage;
            }

            $params[config('dummy-vpos.error_status_key', 'status')] = config('dummy-vpos.error_status_code', 0);
        }

        $callback = $callback . '?' . http_build_query($params);

        return response()->json([
            'callback' => urldecode($callback)
        ]);
    }
}
