# Kosmos: Line Message

## Введение

Отправка сообщений получателю предполагает возможность поставки через один или несколько каналов связи.
Механизм поставки при этом должен быть скрыт.

Идея решения состоит в том, чтобы, опираясь на некоторую конфигурацию и бизнес-логику,
сформировать коллекцию каналов связи, по которым потенциально можно отправить сообщение.
Также формируется максимально возможный контекст &ndash; массив данных, 
который включает как обязательные поля для обработки канала связи (например, email получателя для отправки email),
так и используемые в возможных шаблонах.

Полученные данные принимает отправитель и возвращает коллекцию результатов, из которой можно получить как общий результат, 
так и точечный по каждому каналу связи.

Потенциальное логирование модулем не предусмотрено. Предполагается логирование в вызывающей конструкции и\или на инфраструктурном слое.

## Установка

- Установить модуль

## Использование

### Отправка сообщений по каналам связи

```php
use Bitrix\Main\Loader;
use Kosmos\LineMessage\Line;
use Kosmos\LineMessage\Sender;

Loader::requireModule('kosmos.linemessage');

$someTemplateLine = new Line\Email('SOME_TEMPLATE');
$anotherTemplateLine = new Line\Email('ANOTHER_TEMPLATE');
    
$lineCollection = new Line\Collection(
    $someTemplateLine,
    $anotherTemplateLine
);

$oneMoreTemplateLine = new Line\Email('ONE_MORE_TEMPLATE', true);

$lineCollection->add($oneMoreTemplateLine);

$context = ['EMAIL' => 'test@email.com'];

$lineResultCollection = (new Sender($lines, $context))->send();
```

### Работа с LineResultCollection

```php
$lineResultCollection->isSuccess(); // true, если все сообщения были отправлены
$lineResultCollection->isHandled(); // true, если все каналы обработаны

$lineResultCollection->getSuccessCollection(); // коллекция отправленных
$lineResultCollection->getFailureCollection(); // коллекция неотправленных
$lineResultCollection->getHandledCollection(); // коллекция обработанных
$lineResultCollection->getUnhandledCollection(); // коллекция необработанных
```

#### Получить результат для конкретного Line

```php
$someTemplateLineResult = $lineResultCollection->findByLine($someTemplateLine);
```

### Работа с LineResult

```php
$someTemplateLineResult->isSuccess(); // true, если сообщение было отправлено
$someTemplateLineResult->isHandled(); // true, если канал обработан
```

## Каналы связи

### Email

#### Конструктор

- eventName &ndash; название события
- immediately &ndash; (опционально) немедленная отправка

#### Контекст

- EMAIL &ndash; email получателя
- LID &ndash; (опционально) идентификатор сайта

### Добавление собственного канала связи

Необходимо реализовать интерфейс Kosmos\LineMessage\Line\LineInterface.
Можно наследовать базовый класс Kosmos\LineMessage\Line\Line.
