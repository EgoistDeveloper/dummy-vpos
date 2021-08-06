<?php

return [
    /**
     * Testing route prefix
     */
    'route_prefix' => 'dummy-vpos',

    /**
     * Default password
     */
    'password' => '1234',

    /**
     * Auto fill selected password
     */
    'password_autofill' => true,

    /**
     * Countdown delay for confirmation form
     */
    'confirmation_delay' => 15,

    /**
     * Callback error message key name
     */
    'error_message_key' => 'error',

    /**
     * Callback timeout error message
     */
    'error_timeout_message' => 'Payment process timed out. Please try again.',

    /**
     * Callback cancelation error message
     */
    'error_canceled_message' => 'Payment canceled.',

    /**
     * Callback wrong password message
     */
    'error_password_message' => 'Wrong password, payment failed.',

    /**
     * Callback status key name
     */
    'error_status_key' => 'status',

    /**
     * Callback default error status code
     */
    'error_status_code' => 0,

    /**
     * Callback success message key name
     */
    'success_message_key' => 'message',

    /**
     * Callback default success message
     */
    'success_message' => 'Payment recieved.',

    /**
     * Callback success status key name
     */
    'success_status_key' => 'status',

    /**
     * Callback default success status code
     */
    'success_status_code' => 1,
];
