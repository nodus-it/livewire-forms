<?php

    namespace Tests\Unit\InputTests;

    use Carbon\Carbon;
    use Carbon\Exceptions\InvalidFormatException;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;
    use Tests\Unit\TestCase;

    class TimeInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Time('time_input');

            $this->assertSame('time_input',$input->getLabel());
            $this->assertSame('time_input',$input->getId());
            $this->assertSame('time_input',$input->getName());
            $this->assertSame('time',$input->getType());
            $this->assertSame('values.time_input',$input->getViewId());
            $this->assertSame(null,$input->getHint());
            $this->assertSame('',$input->getValidations());
            $this->assertSame(6,$input->getSize());
            $this->assertSame(null,$input->getDefaultValue());
            $this->assertSame(null,$input->getValue());
        }

        public function testPostValidationMutator()
        {
            $input = new Time('time_input');

            $this->assertSame(null,$input->postValidationMutator(null));
            $this->assertEquals(Carbon::createFromTime(12,34),$input->postValidationMutator('12:34'));
            $this->assertEquals(Carbon::createFromTime(12,34,56),$input->postValidationMutator('12:34:56'));

            $this->expectException(InvalidFormatException::class);
            $input->postValidationMutator('test');
        }

        public function testPreRenderMutator()
        {
            $input = new Time('time_input');
            $this->assertSame(null,$input->preRenderMutator(null));
            $this->assertSame(null,$input->preRenderMutator(''));
            $this->assertSame('12:34:00',$input->preRenderMutator('12:34'));
            $this->assertSame('12:34:56',$input->preRenderMutator('12:34:56'));
            $this->assertSame('12:34:00',$input->preRenderMutator(Carbon::createFromTime(12,34)));
            $this->assertSame('12:34:56',$input->preRenderMutator(Carbon::createFromTime(12,34,56)));
        }
    }