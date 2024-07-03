<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('superAdminPermission', [UserPolicy::class, 'superAdminPermission']);
        Gate::define('adminPermission', [UserPolicy::class, 'adminPermission']);
        ResetPassword::createUrlUsing(function (mixed $notifiable, string $token) {
            if (! $notifiable instanceof CanResetPassword) {
                throw new InvalidArgumentException('The notifiable object must implement CanResetPassword interface.');
            }

            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
