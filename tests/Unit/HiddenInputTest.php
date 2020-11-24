<?php

    namespace Tests\Unit;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;

    class HiddenInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Hidden('hidden_input','test_value');

            $this->assertEquals('',$input->getLabel());
            $this->assertEquals('hidden_input',$input->getId());
            $this->assertEquals('hidden_input',$input->getName());
            $this->assertEquals('hidden',$input->getType());
            $this->assertEquals('values.hidden_input',$input->getViewId());
            $this->assertEquals('test_value',$input->getDefaultValue());
            $this->assertEquals('test_value',$input->getValue());

            $input = Hidden::create('hidden_input','test_value');
            $this->assertEquals('',$input->getLabel());
            $this->assertEquals('hidden_input',$input->getId());
            $this->assertEquals('hidden_input',$input->getName());
            $this->assertEquals('hidden',$input->getType());
            $this->assertEquals('values.hidden_input',$input->getViewId());
            $this->assertEquals('test_value',$input->getDefaultValue());
            $this->assertEquals('test_value',$input->getValue());
        }
    }