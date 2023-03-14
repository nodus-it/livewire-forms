<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Color;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
use Nodus\Packages\LivewireForms\Services\FormBuilder\DateTime;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Decimal;
use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Number;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Password;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Textarea;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class FormInputTest extends TestCase
{
    public function testFormInputCreate()
    {
        $input = new Text('text_input');
        $input2 = Text::create('text_input');

        $this->assertEquals($input, $input2);
    }

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
            [Select::class, 'addSelect'],
            [Checkbox::class, 'addCheckbox'],
            // Note: Richtextarea doesn't support standalone rendering (yet)
            //[RichTextarea::class, 'addRichTextarea'],
            [Hidden::class, 'addHidden'],
            // Note: Code doesn't support standalone rendering (yet)
            //[Code::class, 'addCode'],
        ];
    }

    /**
     * @dataProvider validInputs
     */
    public function testFormInputStandaloneRender($class)
    {
        $input = new $class('test_input', 'test');

        $this->assertIsString($input->render());
        $this->assertIsString($input->__toString());
    }

    public function testHtmlLabel()
    {
        $input = new Text('text_input');
        $this->assertFalse($input->hasHtmlLabel());
        $input->setLabelHtml();
        $this->assertTrue($input->hasHtmlLabel());
    }
}
