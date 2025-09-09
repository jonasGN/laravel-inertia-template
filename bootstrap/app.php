<?php

use App\Exceptions\ResourceException;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            // em desenvolvimento, essa forma de renderizar o erro, é mais útil para visualizarmos
            if (app()->environment(['local', 'testing'])) {
                return $response;
            }

            // lida com erros que podem renderizar a resposta como está
            if ($exception instanceof ValidationException || $exception instanceof AuthenticationException) {
                return $response;
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return back()->withErrors(
                    'Você precisa estar autenticado para acessar essa rota.'
                );
            }
            if ($exception instanceof InvalidSignatureException) {
                return back()->withErrors(
                    'A assinatura da rota não é uma assinatura válida. Ou seja, está expirada ou possui assinatura inválida.'
                );
            }

            // erro de página expirada
            if ($response->getStatusCode() === 419) {
                return back()->with(['message' => 'A página expirou, por favor tente novamente.']);
            }

            // para rotas de recursos, é melhor retornamos o json puro quando não vierem do inertia
            if ($request->is('resources/*') && !$request->header('X-Inertia')) {
                return $exception instanceof ResourceException
                    ? $exception->response()
                    : ResourceException::unhandleResponse($exception);
            }

            return back()->withErrors([
                'exception' => $exception instanceof ResourceException
                    ? $exception->getMessage()
                    : "Ocorreu um erro desconhecido. Se o mesmo persistir, entre em contato com o suporte",
            ]);
        });
    })->create();
