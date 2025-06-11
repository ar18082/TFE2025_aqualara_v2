<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;

class AquaLaraException extends Exception
{
    /**
     * Code d'erreur unique
     */
    protected string $errorCode;

    /**
     * Contexte de l'erreur
     */
    protected array $context = [];

    /**
     * Niveau de sévérité
     */
    protected string $severity = 'error';

    /**
     * Constructeur
     *
     * @param string $message
     * @param string $errorCode
     * @param array $context
     * @param string $severity
     * @param int $code
     */
    public function __construct(
        string $message,
        string $errorCode,
        array $context = [],
        string $severity = 'error',
        int $code = 0
    ) {
        parent::__construct($message, $code);
        $this->errorCode = $errorCode;
        $this->context = $context;
        $this->severity = $severity;
    }

    /**
     * Récupère le code d'erreur
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Récupère le contexte
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Récupère la sévérité
     *
     * @return string
     */
    public function getSeverity(): string
    {
        return $this->severity;
    }

    /**
     * Convertit l'exception en tableau
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getErrorCode(),
            'severity' => $this->getSeverity(),
            'context' => $this->getContext(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceAsString()
        ];
    }
} 