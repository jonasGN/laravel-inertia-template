<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Erro relacionado a recursos (resources) da aplicação, que são nada mais nada menos que as rotas de API
 */
class ResourceException extends Exception
{
    public function __construct(
        string $message,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    // como essa exceção é conhecida e lançada propositalmente, podemos ignorar, mas mantemos os registros
    public function report(): void
    {
        $file = $this->getFile();
        $line = $this->getLine();

        Log::notice("{$this->message} ({$file}:{$line})");
    }

    public function response(): Response
    {
        return response([
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }

    /**
     * Alias para retornar uma resposta de uma exceção não tratada
     */
    public static function unhandleResponse(Throwable $previous): Response
    {
        return (new ResourceException(
            "Ocorreu um erro desconhecido. Se o mesmo persistir, entre em contato com o suporte.",
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $previous,
        ))->response();
    }
}
