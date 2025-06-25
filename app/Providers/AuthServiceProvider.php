<?php

namespace App\Providers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Policies\LabelPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TaskStatusPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        TaskStatus::class => TaskStatusPolicy::class,
        Label::class => LabelPolicy::class,
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
