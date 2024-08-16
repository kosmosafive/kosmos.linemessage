<?php

namespace Kosmos\LineMessage;

use Kosmos\LineMessage\Line\LineCollection;
use Kosmos\LineMessage\Result\LineResultCollection;

class Sender
{
    public static function send(LineCollection $lines, array $context): LineResultCollection
    {
        $resultCollection = new LineResultCollection();
        foreach ($lines as $line) {
            $resultCollection->add($line->send($context));
        }
        return $resultCollection;
    }
}
