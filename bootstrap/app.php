<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aliases preserved from the legacy app/Http/Kernel.php
        $middleware->alias([
            'auth'            => \App\Http\Middleware\Authenticate::class,
            'sentinel.auth'   => \App\Http\Middleware\SentinelAuth::class,
            'auth.basic'      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'bindings'        => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'cache.headers'   => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can'             => \Illuminate\Auth\Middleware\Authorize::class,
            'guest'           => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm'=> \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed'          => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle'        => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified'        => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        // Mirror the previous TrimStrings exceptions
        $middleware->trimStrings(except: [
            'password',
            'password_confirmation',
        ]);

        // Replicate the legacy TrustProxies configuration
        $middleware->trustProxies(headers:
            Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO
            | Request::HEADER_X_FORWARDED_AWS_ELB
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom rendering preserved from app/Exceptions/Handler.php
        $exceptions->render(function (Throwable $e, $request) {
            if ($e instanceof HttpException) {
                $code = $e->getStatusCode();
                if ($code == 404) {
                    return response()->view('error.404', [], 404);
                }
                if ($code == 500) {
                    return response()->view('error.500', [], 500);
                }
            }
        });

        $exceptions->context(function () {
            try {
                $detail = auth()->check()
                    ? (auth()->user()->short_name ?? '').' '.request()->getMethod().' '.request()->getUri()
                    : request()->getHost();
                return ['detail' => $detail];
            } catch (Throwable $ignore) {
                return [];
            }
        });
    })
    ->create();
