<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Kept only to expose the HOME constant referenced by
 * App\Http\Middleware\RedirectIfAuthenticated. Actual route
 * registration happens in bootstrap/app.php via withRouting().
 */
class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';
}
