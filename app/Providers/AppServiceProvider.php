<?php

namespace App\Providers;

use App\Models\Review;
use App\Models\Studio;
use App\Policies\AdminReviewPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\StudioPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        Review::class => ReviewPolicy::class,
        Review::class => AdminReviewPolicy::class,
        Studio::class => StudioPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
