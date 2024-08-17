<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Line;

use Bitrix\Main\Engine\Response\Converter;
use ReflectionClass;

abstract readonly class Line implements LineInterface
{
    public function getConfigId(): string
    {
        $className = (new ReflectionClass($this))->getShortName();
        return (new Converter(Converter::TO_SNAKE))->process($className);
    }
}
