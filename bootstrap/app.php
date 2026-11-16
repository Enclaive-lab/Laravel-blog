<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\RequestMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);

        $middleware->append(RequestMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (ApiException $e): bool {
            if ($e->status >= 400 && $e->status < 500) {
                return false;
            }
            Log::error('ApiException', [
                'message' => $e->getMessage(),
                'status' => $e->status,
                'errors' => $e->errors,
            ]);

            return true;
        });

        $exceptions->report(function (Throwable $e): bool {
            Log::error('Unhandled exception', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
            ]);

            return true;
        });


        $exceptions->render(function (ThrottleRequestsException $e, Request $request): ?JsonResponse {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;

            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
            ], 429, $e->getHeaders());
        });

        $exceptions->render(function (ApiException $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors
            ], $e->status);
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
            ], 404);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Forbidden',
            ], 403);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;
            return response()->json([
                'success'  => false,
                'message' => 'Unauthorized',

            ], 401);
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) return null;

            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

            return response()->json([
                'success' => false,
                'message' => $status >= 500 && !config('app.debug') ? 'Server error' : $e->getMessage(),
            ], $status, $e instanceof HttpExceptionInterface ? $e->getHeaders() : []);
        });
    })->create();
