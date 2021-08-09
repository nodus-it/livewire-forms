<?php

    namespace Tests\Unit\InputTests;

    use Carbon\Carbon;
    use Carbon\Exceptions\InvalidFormatException;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
    use Tests\Unit\TestCase;

    class DateInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Date('date_input');

            $this->assertSame('date_input',$input->getLabel());
            $this->assertSame('date_input',$input->getId());
            $this->assertSame('date_input',$input->getName());
            $this->assertSame('date',$input->getType());
            $this->assertSame('values.date_input',$input->getViewId());
            $this->assertSame(null,$input->getHint());
            $this->assertSame([],$input->getValidations());
            $this->assertSame(6,$input->getSize());
            $this->assertSame(null,$input->getDefaultValue());
            $this->assertSame(null,$input->getValue());
        }

        public function testPostValidationMutator()
        {
            $input = new Date('date_input');

            $this->assertSame(null,$input->postValidationMutator(null));
            $this->assertEquals(Carbon::create(2020,01,23),$input->postValidationMutator('23.01.2020'));

            $this->expectException(InvalidFormatException::class);
            $input->postValidationMutator('test');
        }

        public function testPreRenderMutator()
        {
            $input = new Date('date_input');
            
            $this->assertSame(null,$input->preRenderMutator(null));
            $this->assertSame(null,$input->preRenderMutator(''));
            $this->assertSame('2020-01-23',$input->preRenderMutator('23.01.2020'));
            $this->assertSame('2020-01-23',$input->preRenderMutator('2020-01-23'));
            $this->assertSame('2020-01-23',$input->preRenderMutator(Carbon::createFromDate(2020,01,23)));

            // special case for older safari versions, this behaviour will be deprecated in future
            $this->assertSame('23.01.20201',$input->preRenderMutator('23.01.20201'));
        }
    }