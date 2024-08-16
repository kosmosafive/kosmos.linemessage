<?php

namespace Kosmos\LineMessage\Line;

use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Result;
use Exception;
use Bitrix\Main\Mail\Event;

class EmailLine extends Line
{
    public function __construct(
        protected string $template,
        protected bool $immediately = false
    ) {
    }

    public function canApply(array $context): Result
    {
        $result = new Result();
        if (!isset($context['EMAIL'])) {
            $result->addError(new Error(Loc::getMessage('KOSMOS_LINE_MESSAGE_EMAIL_CAN_APPLY_ERROR')));
        }
        return $result;
    }

    protected function handle(array $context): Result
    {
        $data = [
            'EVENT_NAME' => $this->template,
            'LID' => $context['LID'] ?? SITE_ID,
            'C_FIELDS' => $context
        ];
        return $this->immediately ? $this->eventSendImmediate($data) : $this->eventSend($data);
    }

    protected function eventSend(array $data): Result
    {
        return Event::send($data);
    }

    protected function eventSendImmediate(array $data): Result
    {
        try {
            $flag = Event::sendImmediate($data);
            return $this->getResultByFlag($flag);
        } catch (Exception $e) {
            return (new Result())->addError(new Error($e->getMessage()));
        }
    }

    private function getResultByFlag(string $flag): Result
    {
        $result = new Result();

        if (in_array($flag, [
            Event::SEND_RESULT_ERROR,
            Event::SEND_RESULT_TEMPLATE_NOT_FOUND,
            Event::SEND_RESULT_NONE
        ], true)) {
            $result->addError(new Error(Loc::getMessage('KOSMOS_EMAIL_LINE_ERROR_SEND_RESULT_' . $flag)));
        }

        return $result;
    }

    public function getConfigId(): string
    {
        return 'email';
    }
}
