<?php

    namespace Tests\Unit;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;

    class CheckboxInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Checkbox('checkbox_input');

            $this->assertEquals('checkbox_input',$input->getLabel());
            $this->assertEquals('checkbox_input',$input->getId());
            $this->assertEquals('checkbox_input',$input->getName());
            $this->assertEquals('checkbox',$input->getType());
            $this->assertEquals('values.checkbox_input',$input->getViewId());
            $this->assertEquals(false,$input->getDefaultValue());
            $this->assertEquals(false,$input->getValue());
        }
    }