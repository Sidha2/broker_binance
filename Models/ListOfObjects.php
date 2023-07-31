<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use stdClass;

class ListOfObjects
{
    private array $errors = [];

    public function Add(stdClass $error): void
    {
        $errors[] = $error;
    }

    public function ReadAll(): array
    {
        return $this->errors;
    }

    public function ReadByIndex(int $index): ?stdClass
    {
        if (count($this->errors) > $index)
            return $this->errors[$index];

        return null;
    }

    public function ReadLast(): ?stdClass
    {
        if (count($this->errors) > 0)
            return $this->errors[count($this->errors) - 1];

        return null;
    }
}