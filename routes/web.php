<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/**
 * Реферальная ссылка
 */
Route::name('referrer')->get('ref/{id}', 'IndexController@referral');


/**
 * Главная страница
 */
Route::name('index')->get('/', 'IndexController@index');


/**
 * Новости
 */
Route::name('news')->get('news', 'NewsController@index');


/**
 * Детальный просмотр новостей
 */
Route::name('news.show')->get('news/{item}', 'NewsController@show');


/**
 * Отзывы
 */
Route::name('reviews')->get('reviews', 'ReviewsController@index');


/**
 * Тарифы
 */
Route::name('tariffs')->get('tariffs', 'TariffsController@index');


/**
 * Правила сайта
 */
Route::name('rules')->get('rules', 'RulesController@index');


/**
 * Предупреждение
 */
Route::name('notice')->get('notice', 'NoticeController@index');


/**
 * Контакты (обратная связь)
 */
Route::name('feedback')->get('feedback', 'FeedBackController@index');
Route::post('feedback', 'FeedBackController@add');


/**
 * Партнёрам
 */
Route::get('affiliate', 'AffiliateController@index')
    ->name('affiliate');


/**
 * Наши партнеры
 */
Route::name('partners')->get('partners', 'PartnersController@index');


/**
 * Карта сайта
 */
Route::name('sitemap')->get('sitemap.xml', 'SitemapController@index');


/**
 * Заявка на обмен
 */
Route::group(['prefix' => 'exchange'], function () {


    /**
     * Подтвердить оплату заявки
     */
    Route::name('exchange.confirm')->post('confirm/{exchange}', 'ExchangeController@confirm');


    /**
     * Форма обмена
     */
    Route::name('exchange')->get('{from}/{to}', 'ExchangeController@index');
    Route::post('{from}/{to}', 'ExchangeController@create');


    /**
     * Просмотр заявки на обмен
     */
    Route::name('exchange.show')->get('{exchange}', 'ExchangeController@show');
});


/**
 * Страницы аутентификации
 */
Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {


    /**
     * Регистрация
     */
    Route::name('register')->get('register', 'RegisterController@index');
    Route::post('register', 'RegisterController@register');


    /**
     * Авторизация
     */
    Route::name('login')->get('login', 'LoginController@index');
    Route::post('login', 'LoginController@login');

    /**
     * Восстановление пароля
     */
    Route::name('forgot')->get('forgot', 'ForgotController@index');
    Route::post('forgot', 'ForgotController@reset');

});


/**
 * Выход
 */
Route::name('logout')->get('logout', 'Auth\LogoutController@index');


/**
 * Страницы пользователя
 */
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth'], function () {


    /**
     * Аккаунт
     */
    Route::name('user.account')->get('account', 'AccountController@index');
    Route::name('user.personalData')->post('account/personal', 'AccountController@personalData');
    Route::name('user.changePassword')->post('account/password', 'AccountController@changePassword');


    /**
     * Счёта
     */
    Route::name('user.wallets')->get('wallets', 'WalletsController@index');
    Route::name('user.wallets.save')->post('wallets', 'WalletsController@save');
    Route::name('user.wallets.delete')->get('wallets/delete/{id}', 'WalletsController@delete');


    /**
     * Операции (обмены)
     */
    Route::name('user.operations')->get('operations', 'OperationsController@index');
});


/**
 * Страницы партнера
 */
Route::group(['prefix' => 'partner', 'namespace' => 'Partner', 'middleware' => 'auth', ], function () {


    /**
     * Аккаунт
     */
    Route::name('partner.account')->get('account', 'AccountController@index');

    /**
     * Рефералы
     */
    Route::name('partner.referrals')->get('referrals', 'ReferralsController@index');


    /**
     * Партнерские обмены
     */
    Route::name('partner.exchanges')->get('exchanges', 'ExchangesController@index');


    /**
     * Партнерские переходы
     */
    Route::name('partner.transitions')->get('transitions', 'TransitionsController@index');


    /**
     * Внутренний счёт
     */
    Route::name('partner.balance')->get('balance', 'BalanceController@index');


    /**
     * Выплаты партнерских средств
     */
    Route::name('partner.payouts')->get('payouts', 'PayoutsController@index');
    Route::post('payouts', 'PayoutsController@create');


    /**
     * Рекламные материалы (баннеры)
     */
    Route::name('partner.banners')->get('banners', 'BannersController@index');


    /**
     * Условия участия в партнерской программе
     */
    Route::name('partner.terms')->get('terms', 'TermsController@index');

});


/**
 * Файлы экспорта
 */
Route::group(['namespace' => 'Export', ], function () {


    /**
     * XML
     */
    Route::get('export.xml', 'ExportXMLController@index')
        ->name('export.xml');

    /**
     * TXT
     */
    Route::get('export.txt', 'ExportTXTController@index')
        ->name('export.txt');


    /**
     * JSON
     */
    Route::get('export.json', 'ExportJSONController@index')
        ->name('export.json');
});


/**
 * Страницы оплаты
 */
Route::group(['prefix' => 'pay', 'namespace' => 'Pay', ], function () {

    foreach (config('payment') as $key => $value) {
        Route::any(mb_strtolower($key).'/index', $key.'@index')
            ->name('payment.'.mb_strtolower($key));
        Route::any(mb_strtolower($key).'/fail', $key.'@fail')
            ->name('payment.'.mb_strtolower($key).'.fail');
        Route::any(mb_strtolower($key).'/success', $key.'@success')
            ->name('payment.'.mb_strtolower($key).'.success');
    }
});