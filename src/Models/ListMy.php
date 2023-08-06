<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use InvalidArgumentException;


class ListMy
{
    private array $items = [];
    private $allowedType;

    public function __construct($allowedType)
    {
        $this->allowedType = $allowedType;
    }

    public function Add(object $item): void
    {
        if ($item instanceof $this->allowedType)
            $this->items[] = $item;
        else
            throw new InvalidArgumentException("Only objects of type {$this->allowedType} are allowed.");
    }

    public function ReadAll(): array
    {
        return $this->items;
    }

    public function ReadByIndex(int $index): ?object
    {
        if (count($this->items) > $index)
            return $this->items[$index];

        return null;
    }

    public function ReadLast(): ?object
    {
        if (count($this->items) > 0)
            return $this->items[count($this->items) - 1];

        return null;
    }

    public function Count()
    {
        return count($this->items);
    }
}