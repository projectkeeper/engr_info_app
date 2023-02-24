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

        // 「管理者」だけに適用
        Gate::define('admin', function ($user) {
            return ($user->permission_id == 1);
        });

        // 「管理者」+「エンジニアリーダ/営業/業務」に適用
        Gate::define('lead_sales', function ($user) {
            return ($user->permission_id <= 2);
        });

        // 「管理者」+「エンジニアリーダ/営業/業務」+「エンジニア」に適用
        Gate::define('engineer', function ($user) {
            return ($user->permission_id <= 3);
        });

        // 「Guest」+「管理者」+「エンジニアリーダ/営業/業務」+「エンジニア」に適用
        Gate::define('all', function ($user) {
            return ($user->permission_id <= 4);
        });
    }
}
