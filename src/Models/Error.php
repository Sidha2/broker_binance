<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\ErrorType;

class Error
{
    private string $msg;
    private ErrorType $errorType;
    private string $comesFrom;
    private string $file;
    private int $line;
    private int $timestamp;

    public function __construct(ErrorType $errorType, string $msg, string $comesFrom, string $file, int $line)
    {
        $this->errorType = $errorType;
        $this->msg = $msg;
        $this->comesFrom = $comesFrom;
        $this->file = $file;
        $this->line = $line;
        $this->timestamp = time();
    }

    /**
     * Get the value of msg
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * Get the value of errorType
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * Get the value of comesFrom
     */
    public function getComesFrom()
    {
        return $this->comesFrom;
    }

    /**
     * Get the value of file
     */
    public function getFile($file)
    {
        return $this->file;
    }

    /**
     * Get the value of line
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Get the value of timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}