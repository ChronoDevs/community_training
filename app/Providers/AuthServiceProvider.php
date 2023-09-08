<?php

namespace App\Providers;

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

        // Define the 'update-listing' gate to check if the user can update a listing
        Gate::define('update-listing', function ($user, $listing) {
            return $user->id === $listing->user_id;
        });

        // Define the 'delete-listing' gate to check if the user can delete a listing
        Gate::define('delete-listing', function ($user, $listing) {
            return $user->id === $listing->user_id;
        });
    }
}
