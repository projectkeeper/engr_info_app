<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 「一部」だけに適用
        Gate::define('admin', function ($user) {
            return ($user->permission_id == 1);
        });

        // 「一部」と「通常」に適用
        Gate::define('regular', function ($user) {
            return ($user->permission_id <= 2);
        });

        // 「一部」と「通常」と「管理者」全てに適用
        Gate::define('limited', function ($user) {
            return ($user->permission_id <= 3);
        });
    }
}
