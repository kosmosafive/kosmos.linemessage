<?php

namespace Kosmos\LineMessage\Result;

use Bitrix\Main\Result;
use Kosmos\LineMessage\Line\LineInterface;

class LineResult extends Result
{
    protected bool $isApplied;

    public function __construct(protected LineInterface $line)
    {
        parent::__construct();

        $this->isApplied = false;
    }

    public function getLine(): LineInterface
    {
        return $this->line;
    }

    public function isApplied(): bool
    {
        return $this->isApplied;
    }

    public function setApplied(bool $isApplied): static
    {
        $this->isApplied = $isApplied;
        return $this;
    }
}
