<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//use App\Http\Middleware\Cors;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    //$middleware->add(Cors::class);
    $middleware->validateCsrfTokens(except: [
      'stripe/*',
      'http://192.168.0.6:8000/respuesta/guardar',
  ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
