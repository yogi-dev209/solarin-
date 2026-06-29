<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__.'/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'role'          => \App\Http\Middleware\RoleMiddleware::class,
            'active'        => \App\Http\Middleware\CheckActiveStatus::class,
            'redirect.role' => \App\Http\Middleware\RedirectByRole::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\CheckActiveStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 👇 TANGANI CSRF TOKEN EXPIRED (419)
        $exceptions->render(function (TokenMismatchException $e, $request) {
            // Ambil URL sebelumnya
            $previousUrl = $request->headers->get('referer') ?? url('/');

            // Cek apakah sebelumnya di halaman admin atau sopir
            if (str_contains($previousUrl, '/admin/login')) {
                return redirect()->route('admin.login')
                    ->with('error', '⏳ Sesi login telah kadaluarsa. Silakan refresh halaman dan login kembali.');
            }

            if (str_contains($previousUrl, '/sopir/login')) {
                return redirect()->route('sopir.login')
                    ->with('error', '⏳ Sesi login telah kadaluarsa. Silakan refresh halaman dan login kembali.');
            }

            // Default redirect ke halaman login
            return redirect()->route('login')
                ->with('error', '⏳ Sesi login telah kadaluarsa. Silakan login kembali.');
        });
    })
    ->create();
