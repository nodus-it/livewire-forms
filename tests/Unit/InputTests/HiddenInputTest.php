<?php

    namespace Tests\Unit\InputTests;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;
    use Tests\Unit\TestCase;

    class HiddenInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Hidden('hidden_input','test_value');

            $this->assertSame('',$input->getLabel());
            $this->assertSame('hidden_input',$input->getId());
            $this->assertSame('hidden_input',$input->getName());
            $this->assertSame('hidden',$input->getType());
            $this->assertSame('values.hidden_input',$input->getViewId());
            $this->assertSame('test_value',$input->getDefaultValue());
            $this->assertSame('test_value',$input->getValue());

            $input = Hidden::create('hidden_input','test_value');
            $this->assertSame('',$input->getLabel());
            $this->assertSame('hidden_input',$input->getId());
            $this->assertSame('hidden_input',$input->getName());
            $this->assertSame('hidden',$input->getType());
            $this->assertSame('values.hidden_input',$input->getViewId());
            $this->assertSame('test_value',$input->getDefaultValue());
            $this->assertSame('test_value',$input->getValue());
        }
    }