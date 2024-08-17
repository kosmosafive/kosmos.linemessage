<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Result;

use Bitrix\Main\Result;
use Kosmos\LineMessage\Line\LineInterface;

class LineResult extends Result
{
    protected bool $handled = false;

    public function __construct(
        protected readonly LineInterface $line
    )
    {
        parent::__construct();
    }

    public function getLine(): LineInterface
    {
        return $this->line;
    }

    public function isHandled(): bool
    {
        return $this->handled;
    }

    public function setHandled(bool $handled): LineResult
    {
        $this->handled = $handled;
        return $this;
    }
}
