<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {

    if (!isset($_SESSION)) {
        // server should keep session data for AT LEAST 24 hour
        ini_set('session.gc_maxlifetime', 60 * 60 * 24);

        session_start();

        // each client should remember their session id for EXACTLY 24 hour
        //session_set_cookie_params(60 * 60 * 24);
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};


