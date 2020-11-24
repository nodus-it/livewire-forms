<?php

    namespace Tests\Unit;

    use Carbon\Carbon;
    use Carbon\Exceptions\InvalidFormatException;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;

    class DateInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Date('date_input');

            $this->assertEquals('date_input',$input->getLabel());
            $this->assertEquals('date_input',$input->getId());
            $this->assertEquals('date_input',$input->getName());
            $this->assertEquals('date',$input->getType());
            $this->assertEquals('values.date_input',$input->getViewId());
            $this->assertEquals(null,$input->getHint());
            $this->assertEquals('',$input->getValidations());
            $this->assertEquals(6,$input->getSize());
            $this->assertEquals(null,$input->getDefaultValue());
            $this->assertEquals(null,$input->getValue());
        }

        public function testPostValidationMutator()
        {
            $input = new Date('date_input');

            $this->assertEquals(null,$input->postValidationMutator(null));
            $this->assertEquals(Carbon::create(2020,01,23),$input->postValidationMutator('23.01.2020'));

            $this->expectException(InvalidFormatException::class);
            $input->postValidationMutator('test');
        }

        public function testPreRenderMutator()
        {
            $input = new Date('date_input');
            
            $this->assertEquals(null,$input->preRenderMutator(null));
            $this->assertEquals(null,$input->preRenderMutator(''));
            $this->assertEquals('2020-01-23',$input->preRenderMutator('23.01.2020'));
            $this->assertEquals('2020-01-23',$input->preRenderMutator('2020-01-23'));
            $this->assertEquals('2020-01-23',$input->preRenderMutator(Carbon::createFromDate(2020,01,23)));
        }
    }