<?php


namespace App\Service;

class BaseService
{
    /**
     * @var array
     */
    protected array $errors;

    /**
     * @return array
     */
    protected function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $message
     */
    protected function addError(string $message): void
    {
        $this->errors[] = $message;
    }
}
