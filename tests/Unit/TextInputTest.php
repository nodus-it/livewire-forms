<?php

    namespace Tests\Unit;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;

    class TextInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Text('text_input');

            $this->assertEquals('text_input',$input->getLabel());
            $this->assertEquals('text_input',$input->getId());
            $this->assertEquals('text_input',$input->getName());
            $this->assertEquals('text',$input->getType());
            $this->assertEquals('values.text_input',$input->getViewId());
            $this->assertEquals(null,$input->getHint());
            $this->assertEquals('',$input->getValidations());
            $this->assertEquals(6,$input->getSize());
            $this->assertEquals(null,$input->getDefaultValue());
            $this->assertEquals(null,$input->getValue());
        }
    }