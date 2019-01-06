<?php

namespace App\Providers;

use App\Extensions\Illuminate\Auth\ExtendedUserProvider;
use App\OauthAccessToken;
use App\OauthAuthCode;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::useTokenModel(OauthAccessToken::class);
        Passport::useAuthCodeModel(OauthAuthCode::class);
        /**
         * Register @see \App\Extensions\Illuminate\Auth\ExtendedUserProvider
         */
        Auth::provider('extended', function ($app, $config) {
            $model = $config['model'];
            return new ExtendedUserProvider($app['hash'], $model);
        });
    }
}
