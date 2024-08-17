<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Result;

use Bitrix\Main\ErrorCollection;
use SplObjectStorage;
use Kosmos\LineMessage\Line\LineInterface;

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

    public function getSuccessCollection(): LineResultCollection
    {
        $successCollection = new LineResultCollection();
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if ($lineResult->isSuccess()) {
                $successCollection->add($lineResult);
            }
        }
        return $successCollection;
    }

    public function getFailureCollection(): LineResultCollection
    {
        $successCollection = new LineResultCollection();
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if (!$lineResult->isSuccess()) {
                $successCollection->add($lineResult);
            }
        }
        return $successCollection;
    }

    public function getHandledCollection(): LineResultCollection
    {
        $successCollection = new LineResultCollection();
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if ($lineResult->isHandled()) {
                $successCollection->add($lineResult);
            }
        }
        return $successCollection;
    }

    public function getUnhandledCollection(): LineResultCollection
    {
        $successCollection = new LineResultCollection();
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if (!$lineResult->isHandled()) {
                $successCollection->add($lineResult);
            }
        }
        return $successCollection;
    }

    public function isSuccess(): bool
    {
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if (!$lineResult->isSuccess()) {
                return false;
            }
        }
        return true;
    }

    public function isHandled(): bool
    {
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            if (!$lineResult->isHandled()) {
                return false;
            }
        }
        return true;
    }

    public function getErrorCollection(): ErrorCollection
    {
        $errorCollection = new ErrorCollection();
        foreach ($this->results as $key) {
            /** @var LineResult $lineResult */
            $lineResult = $this->results[$key];
            $errorCollection->add($lineResult->getErrors());
        }
        return $errorCollection;
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
