<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Line;

use Bitrix\Main\Result;

interface LineInterface
{
    public function canHandle(array $context): Result;
    public function handle(array $context): Result;

    public function getConfigId(): string;
}
