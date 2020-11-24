<?php

    namespace Tests\Unit;

    use Carbon\Carbon;
    use Carbon\Exceptions\InvalidFormatException;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;

    class TimeInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Time('time_input');

            $this->assertEquals('time_input',$input->getLabel());
            $this->assertEquals('time_input',$input->getId());
            $this->assertEquals('time_input',$input->getName());
            $this->assertEquals('time',$input->getType());
            $this->assertEquals('values.time_input',$input->getViewId());
            $this->assertEquals(null,$input->getHint());
            $this->assertEquals('',$input->getValidations());
            $this->assertEquals(6,$input->getSize());
            $this->assertEquals(null,$input->getDefaultValue());
            $this->assertEquals(null,$input->getValue());
        }

        public function testPostValidationMutator()
        {
            $input = new Time('time_input');

            $this->assertEquals(null,$input->postValidationMutator(null));
            $this->assertEquals(Carbon::createFromTime(12,34),$input->postValidationMutator('12:34'));
            $this->assertEquals(Carbon::createFromTime(12,34,56),$input->postValidationMutator('12:34:56'));

            $this->expectException(InvalidFormatException::class);
            $input->postValidationMutator('test');
        }

        public function testPreRenderMutator()
        {
            $input = new Time('time_input');
            $this->assertEquals(null,$input->preRenderMutator(null));
            $this->assertEquals(null,$input->preRenderMutator(''));
            $this->assertEquals('12:34:00',$input->preRenderMutator('12:34'));
            $this->assertEquals('12:34:56',$input->preRenderMutator('12:34:56'));
            $this->assertEquals('12:34:00',$input->preRenderMutator(Carbon::createFromTime(12,34)));
            $this->assertEquals('12:34:56',$input->preRenderMutator(Carbon::createFromTime(12,34,56)));
        }
    }