# Ядро проекта modulatte

[![Language](https://img.shields.io/badge/php-%5E7.3-blue)](https://img.shields.io/badge/php-%5E7.3-blue) [![Language](https://img.shields.io/badge/EvolutionCMS-%5E3.0-brightgreen)](https://img.shields.io/badge/EvolutionCMS-%5E3.0-brightgreen) [![Language](https://img.shields.io/badge/Laravel-%5E8.0-red)](https://img.shields.io/badge/Laravel-%5E8.0-red)

Пакет проекта модуля для mmaurice/modulatte-project

## Содержание

-   [Установка](#install)
-   [Назначение каталогов пакета](#package-folders)
-   [Доступные консольные команды](#commands)
-   [Применение](#usage)

## Install

Произвести устновку базового модуля **Modulatte**:

```sh
root@ssh:~/core/custom/packages/main/#: cd assets/modules
root@ssh:~/core/custom/packages/main/assets/modules/#: create-project mmaurice/modulatte-project modulatte
```

## Package Folders

#### Ресурсы (resources)

Каталог ресурсов содержит в себе другие подкаталоги:
-- `scripts` - содержит необходимые для расширения функционала модуля скрипты JS
-- `styles` - содержит необходимые для расширения функционала модуля стили CSS
-- `views` - содержит необходимые для расширения функционала модуля шаблоны BLADE

Важно понимать, что в механике работы модуля используются базовые шаблоны, которые поставляются в пакете `mmaurice\modulatte-support`. Но при необходимости расширить тот или иной файл шаблона blade, необходимо скопировать этот файл (с учётом иерархии каталогов) из каталога `/vendor/mmaurice/modulatte-support/resource/views/*` в каталог `/resources/views/*` модуля. Правда, есть нюанс с каталогом tab в шаблонах пакета. Там содержатся базовые шаблоны для всех табов по-умолчанию. Если необходимо кастомизировать шаблон только для одного таба в модуле, необходимо скопировать файл `/vendor/mmaurice/modulatte-support/resource/views/tab/*` в каталог `/resources/views/tabs/<tab-name>/*`

Кроме этого, в каталоге `resources` допустимо создавать иные необходимые для работы приложения каталоги. Например, `images`, `fonts`, `saas`, `scss` и прочие.

#### Код модулей (modules)

В каталоге `modules` содержится список каталогов модулей. Обязательно с заглавной буквы

В базовом исполнении каталог содержит самые важные для работы модуля файлы:
-- `Controllers` - каталог для размещения логики контроллеров табов
-- `Models` - каталог для размещения моделей табов
-- `Module.php` - базовый файл модуля (для инициилизации и дальнейшего расширения)

Контроллер содержит базовые методы для инициализации работы CRUD-модуля:
-- `index` - метод, отображающий интерфейс главного окна таба модуля
-- `list` - метод для вывода списка сущностей
-- `create` - метод, отображающий интерфейс для создания сущности
-- `update` - метод, отображающий интерфейс для редактирования сущности
-- `delete` - метод для удаления сущности

Кроме этого, есть следующие служебные методы:
-- `actionBar` - метод для управления кнопками Action Bar таба
-- `model` - метод для вывода объекта текущей модели (зависит от таба)

Для больших деталей рекомендуется изучить код исходного контроллера модуля

Модель так же содержит свою иерархию методов и логику работы. **Будет описано позже**

#### Загрузчик (bootstrap.php)

Необходим для предзагрузки ядра модуля. Необходим как альтернатива autoload, но в будущем (после перехода на мультимодуль) скорее всего утратит смысл.

#### Точка входа (index.php)

Точка входа, необходимая для подключения загрузчика модуля, а так же копируется при развёртывании поставки в публичный каталог модулей

#### Инициализация модулей (initialize.php)

Точка входа, необходимая для инициализации загрузчика модуля

## Commands

Команды в данный момент не поддерживаются, но планируется их создание в будущем.

## Usage

#### Базовое применение

Реализация простейшего применения представлена в каталоге SiteContentModule модуля (`~/modules/SiteContentModule/`). Для начала необходимо завести файл модуля:

```php
namespace Modulatte\Module\SiteContentModule;

class Module extends \mmaurice\modulatte\Support\Module
{
    // Наименование модуля
    public function name()
    {
        return 'Справочник ресурсов';
    }

    // Основная иконка модуля
    public function icon()
    {
        return 'fa fa-folder-open';
    }

    // Номер позиции в общем списке модулей
    public function position()
    {
        return 10;
    }
}
```

Далее, необходимо создать контроллер (MainController - контроллер по-умолчанию и его наличие обязательно), в котором достаточно перечислить следующие параметры:

```php
namespace Modulatte\Module\SiteContentModule\Controllers;

use Modulatte\Module\SiteContentModule\Models\SiteContent;

class MainController extends \mmaurice\modulatte\Support\Controllers\CrudController
{
    // Порядковый номер позиции модуля в табах (не обязательно)
    protected $position = 0;

    // Уникальное наименование модуля (обязательно)
    protected $slug = 'main';

    // Наименование таба (Обязательно)
    protected $name = 'Страны';

    // Релевантная модель (используется расширенная базовая модель Eloquent)
    protected $model = Countries::class;

    // Ограничение в выодаче результатов на страницу пагинации (не обязательно)
    // 0 для отключения. По-умолчанию, 25
    protected $pagination = 25;
}
```

Данный контроллер работает вместе с релевантной моделью. Её необходимо создать в каталоге Models. В базовом исполнении она может выглядеть следующим образом:

```php
namespace Modulatte\Module\SiteContentModule\Models;

use Illuminate\Http\Request;
use mmaurice\modulatte\Support\Traits\Model\ModuleExtensionTrait;

class SiteContent extends \EvolutionCMS\Models\SiteContent
{
    use ModuleExtensionTrait;

    // Массив наименований полей
    public function fieldsNames()
    {
        return [];
    }

    // Массив полей, выводимых в таблице общего списка
    public function listFields()
    {
        return [];
    }

    // Массив полей, выводимых в интерфейсе создания\изменения записи
    public function itemFields()
    {
        return [];
    }

    // Массив полей, доступных для фильтрации
    public function filterFields()
    {
        return [];
    }

    // Массив полей, доступных для сортировки общего списка
    public function orderFields()
    {
        return [];
    }

    // Массив классов для полей в общем списке
    public function listFieldsClasses()
    {
        return [];
    }

    // Массив классов для полей в интерфейсе создания\изменения записи
    public function itemFieldsClasses()
    {
        return [];
    }

    // Массив классов для полей фильтра
    public function filterFieldsClasses()
    {
        return [];
    }
}
```

Более подробно можно посмотреть реализацию в модели `~/modules/SiteContentModule/Models/SiteContent.php`.

#### Продвинутое применение

Продвинутое применение предоставляет расширенный инструмент для кастомизации базового функционала модулей. Ниже приведен список типичных примеров:

##### Иерархические сущности

В интерфейсе редактирования какой-либо записи можно реализовать возможность вывода списка дочерних записей из подчиненной реляциями таблицы. Это можно сделать, добавив метод `childs` в свой контроллер:

```php
    public function childs()
    {
        $this->addChild('regions', 'country_id', 'id');
    }
```

Основная магия происходит в методе addChild. Первый параметр - это slug другого контроллера, который необходимо подчинить. Второй параметр - это наименование поля в модели связанного контроллера, по которому происходит реляция. Третий параметр - это наименование PK-поля в модели текущего контроллера. В методе childs можно перечислить несколько подчинений. В таком случае списки будут выведены по очереди.

##### Действия

Контроллер поддерживает базовые действия, такие как:

-- `index()` - базовый метод, выводимый при обращении к табу без указания метода. По-умолчанию, вызывает метод `list()`
-- `list()` - метод вывода списка записей
-- `create()` - метод создания записи
-- `update()` - метод обновления записи
-- `delete()` - метод удаления записи

Ознакомившись с исходным кодом этих методов, можно кастомизировать каждое поведение модуля.

##### Action Bar

В методе `actionBar()` контроллера можно кастомизировать для каждого действия выводимые кнопки в actionBar. В исходном коде указан исчерпывающий пример реализации таких кнопок.

##### Кастомизация вывода полей

В модели можно задать кастомизацию для вывода любого поля в любом интерфейсе. Ознакомившись с иерархией шаблонов, можно понять какие типы полей уже можно вывести, а какие придётся запрограммировать самостоятельно. Для реализации кастомизации необходимо использовать методы-мутаторы с указанием поля в наименовании. Список таких методов:

-- `get{FieldName}ListHeadField()` - метод, кастомизирующий вывод заголовка поля {FieldName} в списочном интерфейсе. По-умолчанию, выводится значение как текст
-- `get{FieldName}ListField()` - метод, кастомизирующий вывод поля {FieldName} в списочном интерфейсе. По-умолчанию, выводится значение как текст
-- `get{FieldName}EditorField()` - метод, кастомизирующий вывод поля {FieldName} в интерфейсе редактирования. По-умолчанию, выводится как текстовый input
-- `get{FieldName}FilterField()` - метод, кастомизирующий вывод поля {FieldName} в панели фильтра. По-умолчанию, выводится как текстовый input

В примере модели есть исчерпывающие примеры для реализации каждого типа. Рекомендуется ознакомиться с исходным кодом.

##### Кастомизация правил фильтрации

Для кастомизации правил фильтрации по определенному полю в моделях предусмотрен метод `filterRules()`, в котором могут быть перечислены callback-методы для фильтрации результата по определенному полю. По-умолчанию, фильтрация происходит по строгому соответствию значений. Но возмодны варианты, когда необходимо отфильтровать результат, например, между двух дат. Тогда, правила фильтрации могут выглядеть так:

```php
    public function filterRules()
    {
        return [
            'date_start' => function ($query) {
                $field = $this->mappedFilterFieldValue('date_start');

                $query->when(!is_null($field) and !empty($field), function ($query) use ($field) {
                    $query->where('date_start', '>=', $field);
                });

                return $query;
            },
            'date_end' => function ($query) {
                $field = $this->mappedFilterFieldValue('date_end');

                $query->when(!is_null($field) and !empty($field), function ($query) use ($field) {
                    $query->where('date_end', '<=', $field);
                });

                return $query;
            },
        ];
    }
```

В общем виде, правила фильтрации работают как scope-методы в моделях Eloquent
