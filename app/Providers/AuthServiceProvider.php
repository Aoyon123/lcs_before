<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

    // protected $policies = [
    //     'App\Model' =&gt; 'App\Policies\ModelPolicy',
    // ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
        Passport::routes();

       // $this->registerPolicies();
        // if(! $this->app->routesAreCached()){
        //     Passport::routes();
        // }
      //  Passport::routes();

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     if ($request->input('api_token')) {
        //         return User::where('api_token', $request->input('api_token'))->first();
        //     }
        // });
    }
}
