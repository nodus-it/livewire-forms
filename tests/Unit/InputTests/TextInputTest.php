<?php

    namespace Tests\Unit\InputTests;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
    use Tests\Unit\TestCase;

    class TextInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Text('text_input');

            $this->assertSame('text_input',$input->getLabel());
            $this->assertSame('text_input',$input->getId());
            $this->assertSame('text_input',$input->getName());
            $this->assertSame('text',$input->getType());
            $this->assertSame('values.text_input',$input->getViewId());
            $this->assertSame(null,$input->getHint());
            $this->assertSame([],$input->getValidations());
            $this->assertSame(6,$input->getSize());
            $this->assertSame(null,$input->getDefaultValue());
            $this->assertSame(null,$input->getValue());
        }

        public function testSupports()
        {
            $this->assertTrue(Text::supports('placeholder'));
            $this->assertTrue(Text::supports('Size'));
            $this->assertFalse(Text::supports('test-trait-name'));
        }
    }