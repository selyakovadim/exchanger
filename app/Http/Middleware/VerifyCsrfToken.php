<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function __construct(Application $app, Encrypter $encrypter)
    {
        foreach (config('payment') as $key => $value) {
            $this->except[] = 'pay/' . mb_strtolower($key) . '/index';
            $this->except[] = 'pay/' . mb_strtolower($key) . '/fail';
            $this->except[] = 'pay/' . mb_strtolower($key) . '/success';
        }

        parent::__construct($app, $encrypter);
    }
}
