<?php

    namespace Tests\Unit\InputTests;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;
    use Tests\Unit\TestCase;

    class CheckboxInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Checkbox('checkbox_input');

            $this->assertSame('checkbox_input',$input->getLabel());
            $this->assertSame('checkbox_input',$input->getId());
            $this->assertSame('checkbox_input',$input->getName());
            $this->assertSame('checkbox',$input->getType());
            $this->assertSame('values.checkbox_input',$input->getViewId());
            $this->assertSame(false,$input->getDefaultValue());
            $this->assertSame(false,$input->getValue());
        }
    }