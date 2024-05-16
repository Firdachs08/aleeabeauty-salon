<?php

namespace App\Providers;

//use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('tag_create', function (User $user) {
            return $user->role === 'admin';
        });
        Gate::define('category_create', function (User $user) {
            return $user->role === 'admin';
        });
    
        Gate::define('product_create', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
