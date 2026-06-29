<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class Handler extends ExceptionHandler
{
    protected $dontReport = [];
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(
            function (Throwable $error) {}
        );
    }

    public function render($request, Throwable $exception): Response
    {
        if($this->isHttpException($exception)){
            $code = $exception->getStatusCode();

            if ($code == '404') { return response()->view('error.404'); }
            if ($code == '500') { return response()->view('error.500'); }
        }

        return parent::render($request, $exception);
    }

    protected function context(): array
    {
        return array_merge(parent::context(), [
            'detail' => $this->getDetail()
        ]);
    }

    private function getDetail(): string
    {
        if (auth()->check()) {
            return (
                auth()->user()->short_name . ' ' . 
                request()->getMethod() . ' ' . 
                request()->getUri()
            );
        }

        return request()->getHost();
    }
}
