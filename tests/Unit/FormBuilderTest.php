<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Nodus\Packages\LivewireForms\Livewire\FormView;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Code;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Color;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Currency;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
use Nodus\Packages\LivewireForms\Services\FormBuilder\DateTime;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Decimal;
use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Html;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Number;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Password;
use Nodus\Packages\LivewireForms\Services\FormBuilder\RichTextarea;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Textarea;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;
use Nodus\Packages\LivewireForms\Tests\TestCase;

use function PHPUnit\Framework\assertInstanceOf;

class FormBuilderTest extends TestCase
{
    public static function validInputs()
    {
        return [
            [Text::class, 'addText'],
            [Color::class, 'addColor'],
            [Password::class, 'addPassword'],
            [File::class, 'addFile'],
            [Number::class, 'addNumber'],
            [Textarea::class, 'addTextarea'],
            [Date::class, 'addDate'],
            [Time::class, 'addTime'],
            [DateTime::class, 'addDateTime'],
            [Decimal::class, 'addDecimal'],
            [Currency::class, 'addCurrency'],
            [Select::class, 'addSelect'],
            [Checkbox::class, 'addCheckbox'],
            [RichTextarea::class, 'addRichTextarea'],
            [Hidden::class, 'addHidden'],
            [Code::class, 'addCode'],
            [Html::class, 'addSection'],
            [Html::class, 'addNewLine'],
            [Html::class, 'addHtml'],
        ];
    }

    /**
     * @dataProvider validInputs
     */
    public function testReturnTypes($expected, $method)
    {
        $view = new class() extends FormView {

            public static string $expected;

            public function inputs()
            {
                $method = func_get_arg(0);

                $this->$method($method, $method);

                assertInstanceOf(static::$expected, $this->$method($method, $method));
            }
        };
        $view::$expected = $expected;
        $view->inputs($method);

        if ($method === 'addNewLine') {
            return;
        }

        $this->assertInstanceOf($expected, $view->getInput($method));
    }
}
