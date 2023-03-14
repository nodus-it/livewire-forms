<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Number;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class TraitsTest extends TestCase
{
    public function testSupportsDefaultValue()
    {
        $input = new Text('text_input');
        $this->assertSame(null, $input->getDefaultValue());
        $this->assertSame(null, $input->getValue());

        $this->assertInstanceOf(Text::class, $input->setDefaultValue('default_value'));
        $this->assertSame('default_value', $input->getDefaultValue());
        $this->assertSame('default_value', $input->getValue(null));
        $this->assertSame('model_value', $input->getValue('model_value'));

        $input = new Date('date_input');
        $date = Carbon::create(2020, 01, 01);
        $this->assertInstanceOf(Date::class, $input->setDefaultValue($date));
        $this->assertSame($date, $input->getDefaultValue());
        $this->assertSame($date, $input->getValue(null));
        $this->assertEquals(Carbon::create(2020, 01, 02), $input->getValue(Carbon::create(2020, 01, 02)));
        $this->assertInstanceOf(Date::class, $input->setDefaultValue('23.01.2020'));
        $this->assertEquals(Carbon::create(2020, 01, 23), $input->getDefaultValue());
    }

    public function testSupportsHint()
    {
        $input = new Text('text_input');
        $this->assertSame(null, $input->getHint());
        $this->assertInstanceOf(Text::class, $input->setHint('input_hint'));
        $this->assertSame('input_hint', $input->getHint());
    }

    public function testSupportsMultiple()
    {
        $input = new Select('select_input');
        $this->assertSame(false, $input->getMultiple());
        $this->assertInstanceOf(Select::class, $input->setMultiple());
        $this->assertSame(true, $input->getMultiple());
    }

    public function testSupportsSize()
    {
        $input = new Text('text_input');
        $this->assertSame(6, $input->getSize());
        $this->assertInstanceOf(Text::class, $input->setSize(4));
        $this->assertSame(12, $input->getSize());
        config()->set('livewire-forms.theme');
        $this->assertSame(4, $input->getSize());
    }

    public function testSupportsValidations()
    {
        $input = new Text('text_input');
        $this->assertSame('', $input->getValidations());
        $this->assertInstanceOf(Text::class, $input->setValidations('required'));
        $this->assertSame('required', $input->getValidations());

        $this->assertInstanceOf(Text::class, $input->setValidations('unique:mysql.test,id'));
        $this->assertSame('unique:mysql.test,id,1', $input->rewriteValidationRules(new TestModel(['id' => 1])));
    }

    public function validTranslations()
    {
        return [
            ['DeselectAllText', 'deselect_all'],
            ['SelectAllText', 'select_all'],
            ['NoneSelectedText', 'none_selected'],
            ['NoneResultsText', 'none_results'],
            ['_NotExistingTest1', null],
            ['_NotExistingTest2Text', null],
        ];
    }

    /**
     * @dataProvider validTranslations
     */
    public function testSupportsTranslations($method, $trans)
    {
        $input = Select::create('select_input');

        if ($trans === null) {
            $this->expectException(InvalidArgumentException::class);
        }

        $this->assertSame(
            trans('nodus.packages.livewire-forms::forms.bootstrap_select.' . $trans),
            $input->{'get' . $method}()
        );
        $this->assertInstanceOf(Select::class, $input->{'set' . $method}('test_translation'));
        $this->assertSame(trans('test_translation'), $input->{'get' . $method}());
    }

    public function testSupportsTranslationsInvalidCalls()
    {
        $input = Select::create('select_input');

        $this->expectException(InvalidArgumentException::class);
        $input->_randomMethodText();
    }

    public function testSupportsPlaceholder()
    {
        $input = new Text('text_input');
        $this->assertSame('text_input', $input->getPlaceholder());
        $this->assertSame(true, $input->hasPlaceholder());

        $this->assertInstanceOf(Text::class, $input->setPlaceholder('custom_placeholder'));
        $this->assertSame('custom_placeholder', $input->getPlaceholder());
        $this->assertSame(true, $input->hasPlaceholder());

        $this->assertInstanceOf(Text::class, $input->setPlaceholder(''));
        $this->assertSame(null, $input->getPlaceholder());
        $this->assertSame(false, $input->hasPlaceholder());
    }

    public function testSupportsInputMode()
    {
        $input = new Text('text_input');
        $this->assertNull($input->getInputMode());

        $this->assertInstanceOf(Text::class, $input->setInputMode('email'));
        $this->assertSame('email', $input->getInputMode());

        $this->assertInstanceOf(Text::class, $input->setInputMode('invalid-mode'));
        $this->assertSame('text', $input->getInputMode());
    }

    public function testSupportsMinMax()
    {
        $input = new Number('number_input');
        $this->assertNull($input->getMin());
        $this->assertNull($input->getMax());
        $this->assertNull($input->getStep());

        $this->assertInstanceOf(Number::class, $input->setMin(0));
        $this->assertSame(0, $input->getMin());

        $this->assertInstanceOf(Number::class, $input->setMax(100));
        $this->assertSame(100, $input->getMax());

        $this->assertInstanceOf(Number::class, $input->setStep(1));
        $this->assertSame(1, $input->getStep());
    }

    public function testSupportsArrayValidations()
    {
        $input = new File('file_input');
        $this->assertSame('', $input->getArrayValidations());
        $this->assertInstanceOf(File::class, $input->setArrayValidations('file|mimetypes:video/avi'));
        $this->assertSame('file|mimetypes:video/avi', $input->getArrayValidations());
    }
}

class TestModel extends Model
{
    protected $table = 'test';
    protected $fillable = ['id'];
}
