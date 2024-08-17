<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Structure;

abstract class Collection implements \ArrayAccess, \Iterator, \Countable
{
    protected array $values;

    public function __construct()
    {
        $this->values = [];
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return current($this->values);
    }

    public function next(): void
    {
        next($this->values);
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return key($this->values);
    }

    public function valid(): bool
    {
        return ($this->key() !== null);
    }

    public function rewind(): void
    {
        reset($this->values);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->values[$offset]) || array_key_exists($offset, $this->values);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (isset($this->values[$offset]) || array_key_exists($offset, $this->values)) {
            return $this->values[$offset];
        }

        return null;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function isEmpty(): bool
    {
        return empty($this->values);
    }

    public function with(string $field, $value): self
    {
        $collection = new static();

        foreach ($this->values as $obj) {
            $method = 'get' . ucfirst($field);

            if ($obj->$method() !== $value) {
                continue;
            }

            $collection->add($obj);
        }

        return $collection;
    }

    public function asArray(): array
    {
        return $this->values;
    }
}
