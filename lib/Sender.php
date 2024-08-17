<?php

declare(strict_types=1);

namespace Kosmos\LineMessage;

use Kosmos\LineMessage\Result\LineResult;
use Kosmos\LineMessage\Result\LineResultCollection;

class Sender
{
    protected ?LineResultCollection $lineResultCollection = null;

    public function __construct(
        protected readonly Line\Collection $lineCollection,
        protected readonly array $context
    ) {
    }

    public function send(): LineResultCollection
    {
        if (!$this->lineResultCollection) {
            $this->lineResultCollection = new LineResultCollection();
            foreach ($this->lineCollection as $line) {
                $this->lineResultCollection->add($this->sendLine($line));
            }
        }

        return $this->lineResultCollection;
    }

    protected function sendLine(Line\LineInterface $line): LineResult
    {
        $result = new LineResult($line);

        $canApplyResult = $line->canHandle($this->context);
        if (!$canApplyResult->isSuccess()) {
            return $result->addErrors($canApplyResult->getErrors());
        }
        $result->setHandled(true);

        $handleResult = $line->handle($this->context);
        if (!$handleResult->isSuccess()) {
            return $result->addErrors($handleResult->getErrors());
        }

        return $result->setData($handleResult->getData());
    }
}
