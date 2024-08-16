<?php

namespace Kosmos\LineMessage\Line;

use Bitrix\Main\Result;
use Kosmos\LineMessage\Result\LineResult;

abstract class Line implements LineInterface
{
    abstract public function canApply(array $context): Result;

    abstract protected function handle(array $context): Result;

    final public function send(array $context = []): LineResult
    {
        $result = new LineResult($this);

        $canApplyResult = $this->canApply($context);
        if (!$canApplyResult->isSuccess()) {
            return $result->addErrors($canApplyResult->getErrors());
        }
        $result->setApplied(true);

        $handleResult = $this->handle($context);
        if (!$handleResult->isSuccess()) {
            return $result->addErrors($handleResult->getErrors());
        }
        $result->setData($handleResult->getData());

        return $result;
    }

    abstract public function getConfigId(): string;
}
