<?php

    namespace Tests\Unit;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;

    class TraitsTest extends TestCase
    {
        public function testSupportsDefaultValue()
        {
            $input = new Text('text_input');
            $this->assertEquals(null,$input->getDefaultValue());
            $this->assertEquals(null,$input->getValue());

            $this->assertInstanceOf(Text::class, $input->setDefaultValue('default_value'));
            $this->assertEquals('default_value',$input->getDefaultValue());
            $this->assertEquals('default_value',$input->getValue(null));
            $this->assertEquals('model_value',$input->getValue('model_value'));

            $input = new Date('date_input');
            $date = Carbon::create(2020,01,01);
            $this->assertInstanceOf(Date::class, $input->setDefaultValue($date));
            $this->assertEquals($date,$input->getDefaultValue());
            $this->assertEquals($date,$input->getValue(null));
            $this->assertEquals(Carbon::create(2020,01,02),$input->getValue(Carbon::create(2020,01,02)));
            $this->assertInstanceOf(Date::class, $input->setDefaultValue('23.01.2020'));
            $this->assertEquals(Carbon::create(2020,01,23),$input->getDefaultValue());
        }

        public function testSupportsHint()
        {
            $input = new Text('text_input');
            $this->assertEquals(null,$input->getHint());
            $this->assertInstanceOf(Text::class,$input->setHint('input_hint'));
            $this->assertEquals('input_hint',$input->getHint());
        }

        public function testSupportsMultiple()
        {
            $input = new Select('select_input');
            $this->assertEquals(false,$input->getMultiple());
            $this->assertInstanceOf(Select::class,$input->setMultiple());
            $this->assertEquals(true,$input->getMultiple());
        }

        public function testSupportsSize()
        {
            $input = new Text('text_input');
            $this->assertEquals(6,$input->getSize());
            $this->assertInstanceOf(Text::class,$input->setSize(4));
            $this->assertEquals(12,$input->getSize());
            config()->set('livewire-forms.theme');
            $this->assertEquals(4,$input->getSize());
        }

        public function testSupportsValidations()
        {
            $input = new Text('text_input');
            $this->assertEquals('',$input->getValidations());
            $this->assertInstanceOf(Text::class,$input->setValidations('required'));
            $this->assertEquals('required',$input->getValidations());

            $this->assertInstanceOf(Text::class,$input->setValidations('unique:mysql.test,id'));
            $this->assertEquals('unique:mysql.test,id,1',$input->rewriteValidationRules(new TestModel(['id' => 1])));
        }
    }

    class TestModel extends Model
    {
        protected $table = 'test';
        protected $fillable = ['id'];
    }