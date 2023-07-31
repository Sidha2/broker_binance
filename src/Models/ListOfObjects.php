<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use stdClass;

class ListOfObjects
{
    private array $items = [];

    public function Add(stdClass $item): void
    {
        $this->items[] = $item;
    }

    public function ReadAll(): array
    {
        return $this->items;
    }

    public function ReadByIndex(int $index): ?stdClass
    {
        if (count($this->items) > $index)
            return $this->items[$index];

        return null;
    }

    public function ReadLast(): ?stdClass
    {
        if (count($this->items) > 0)
            return $this->items[count($this->items) - 1];

        return null;
    }
}