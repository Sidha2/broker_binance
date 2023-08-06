<?php
declare(strict_types=1);
namespace BrokerBinance\Models;


class ListOfObjects
{
    private array $items = [];

    public function Add(object $item): void
    {
        $this->items[] = $item;
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
}