<?php

namespace Kosmos\LineMessage\Line;

use Kosmos\LineMessage\Result\LineResult;

interface LineInterface
{
    public function send(array $context = []): LineResult;

    public function getConfigId(): string;
}
