<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
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
        Passport::personalAccessTokensExpireIn(Carbon::now()->addSecond(10));
        Passport::refreshTokensExpireIn(Carbon::now()->addSecond(10));
    }
}
