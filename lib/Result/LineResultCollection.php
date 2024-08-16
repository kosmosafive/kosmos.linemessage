<?php

namespace Kosmos\LineMessage\Result;

use Bitrix\Main\Error;
use Kosmos\LineMessage\Line\LineInterface;
use SplObjectStorage;

class LineResultCollection implements \ArrayAccess, \Iterator, \Countable
{
    protected SplObjectStorage $results;

    public function __construct()
    {
        $this->results = new SplObjectStorage();
    }

    public function add(LineResult $result): LineResultCollection
    {
        $this->results->attach($result->getLine(), $result);
        return $this;
    }

    public function findByLine(LineInterface $line): ?LineResult
    {
        return $this->results[$line] ?? null;
    }

    public function isSuccess(): bool
    {
        foreach ($this->results as $_) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results->getInfo();
            if (!$lineResult->isSuccess()) {
                return false;
            }
        }
        return true;
    }

    public function isApplied(): bool
    {
        foreach ($this->results as $_) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results->getInfo();
            if (!$lineResult->isApplied()) {
                return false;
            }
        }
        return true;
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->results as $_) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results->getInfo();
            $errors[] = $lineResult->getErrors();
        }
        return array_merge(...$errors);
    }

    public function current(): LineResult
    {
        return $this->results->getInfo();
    }

    public function next(): void
    {
        $this->results->next();
    }

    public function key(): int
    {
        return $this->results->key();
    }

    public function valid(): bool
    {
        return $this->results->valid();
    }

    public function rewind(): void
    {
        $this->results->rewind();
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->results->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->results->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->results->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->results->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->results->count();
    }
}
