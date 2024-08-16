# Kosmos: LineMessage

## Установка

- Установить модуль

## Использование

### Отправка сообщений по каналам связи

```php
use Bitrix\Main\Loader;
use Kosmos\LineMessage\Line\EmailLine;
use Kosmos\LineMessage\Line\LineCollection;
use Kosmos\LineMessage\Sender;

Loader::includeModule('kosmos.linemessage');

$someTemplateLine = new EmailLine('SOME_TEMPLATE');
$anotherTemplateLine = new EmailLine('ANOTHER_TEMPLATE');
    
$lines = (new LineCollection())
    ->add($someTemplateLine)
    ->add($anotherTemplateLine);

$context = ['EMAIL' => 'test@email.com'];

/** @var LineResultCollection $result */
$result = Sender::send($lines, $context);

```

### Работа с LineResultCollection

```php
$result->isSuccess(); // true если все сообщения были отправлены
$result->isApplied(); // true если все валидации $context были пройдены
```

#### Получить результат для конкретного Line

```php
/** @var LineResult $someTemplateLineResult */
$someTemplateLineResult = $result->findByLine($someTemplateLine);
```

### Работа с LineResult

```php
$someTemplateLineResult->isSuccess(); // true если сообщение было отправлено
$someTemplateLineResult->isApplied(); // true если $context валидный
```
