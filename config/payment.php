<?php

return [

    /**
     * Payeer
     */
    'Payeer' => [
        'sci' => [
            'account' => env('PAYEER_SCI_ACCOUNT', ''),
            'id' => env('PAYEER_SCI_ID', ''),
            'key' => env('PAYEER_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('PAYEER_API_ACCOUNT', ''),
            'id' => env('PAYEER_API_ID', ''),
            'key' => env('PAYEER_API_KEY', ''),
        ]
    ],

    /**
     * PerfectMoney
     */
    'PerfectMoney' => [
        'sci' => [
            'account' => env('PERFECTMONEY_SCI_ACCOUNT', ''),
            'key' => env('PERFECTMONEY_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('PERFECTMONEY_API_ACCOUNT', ''),
            'id' => env('PERFECTMONEY_API_ID', ''),
            'key' => env('PERFECTMONEY_API_KEY', ''),
        ]
    ],

    /**
     * Qiwi
     */
    'Qiwi' => [
        'sci' => [
            'account' => env('QIWI_SCI_ACCOUNT', ''),
            'id' => env('QIWI_SCI_ID', ''),
            'key' => env('QIWI_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('QIWI_API_ACCOUNT', ''),
            'id' => env('QIWI_API_ID', ''),
            'key' => env('QIWI_API_KEY', ''),
        ]
    ],

    /**
     * AdvCash
     */
    'AdvCash' => [
        'sci' => [
            'account' => env('ADVCASH_SCI_ACCOUNT', ''),
            'id' => env('ADVCASH_SCI_ID', ''),
            'key' => env('ADVCASH_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('ADVCASH_API_ACCOUNT', ''),
            'id' => env('ADVCASH_API_ID', ''),
            'key' => env('ADVCASH_API_KEY', ''),
        ]
    ],


    /**
     * YandexMoney
     */
    'YandexMoney' => [
        'sci' => [
            'account' => env('YANDEXMONEY_SCI_ACCOUNT', ''),
            'id' => env('YANDEXMONEY_SCI_ID', ''),
            'key' => env('YANDEXMONEY_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('YANDEXMONEY_API_ACCOUNT', ''),
            'id' => env('YANDEXMONEY_API_ID', ''),
            'key' => env('YANDEXMONEY_API_KEY', ''),
        ]
    ],

    /**
     * Bitcoin
     */
    'Bitcoin' => [
        'sci' => [
            'account' => env('BITCOIN_SCI_ACCOUNT', ''),
            'id' => env('BITCOIN_SCI_ID', ''),
            'key' => env('BITCOIN_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('BITCOIN_API_ACCOUNT', ''),
            'id' => env('BITCOIN_API_ID', ''),
            'key' => env('BITCOIN_API_KEY', ''),
        ]
    ],

    /**
     * OkPay
     */
    'OkPay' => [
        'sci' => [
            'account' => env('OKPAY_SCI_ACCOUNT', ''),
            'id' => env('OKPAY_SCI_ID', ''),
            'key' => env('OKPAY_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('OKPAY_API_ACCOUNT', ''),
            'id' => env('OKPAY_API_ID', ''),
            'key' => env('OKPAY_API_KEY', ''),
        ]
    ],

    /**
     * NixMoney
     */
    'NixMoney' => [
        'sci' => [
            'account' => env('NIXMONEY_SCI_ACCOUNT', ''),
            'id' => env('NIXMONEY_SCI_ID', ''),
            'key' => env('NIXMONEY_SCI_KEY', ''),
        ],
        'api' => [
            'account' => env('NIXMONEY_API_ACCOUNT', ''),
            'id' => env('NIXMONEY_API_ID', ''),
            'key' => env('NIXMONEY_API_KEY', ''),
        ]
    ],

    /**
     * Tinkoff
     */
    'Tinkoff' => [
        'sci' => [
            'account' => env('TINKOFF_SCI_ACCOUNT', ''),
        ]
    ],

    /**
     * Sberbank
     */
    'Sberbank' => [
        'sci' => [
            'account' => env('SBERBANK_SCI_ACCOUNT', ''),
        ]
    ],

];