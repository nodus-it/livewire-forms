<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Textarea;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class TextareaInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Textarea('textarea_input');

        $this->assertSame('textarea_input', $input->getLabel());
        $this->assertSame('textarea_input', $input->getId());
        $this->assertSame('textarea_input', $input->getName());
        $this->assertSame('textarea', $input->getType());
        $this->assertSame('values.textarea_input', $input->getViewId());
        $this->assertSame(null, $input->getHint());
        $this->assertSame('', $input->getValidations());
        $this->assertSame(6, $input->getSize());
        $this->assertSame(null, $input->getDefaultValue());
        $this->assertSame(null, $input->getValue());
        $this->assertSame(null, $input->getRows());
    }

    public function testSupports()
    {
        $this->assertTrue(Text::supports('placeholder'));
        $this->assertTrue(Text::supports('Size'));
        $this->assertFalse(Text::supports('test-trait-name'));
    }

    public function testRows()
    {
        $input = new Textarea('textarea_input');

        $this->assertSame(null, $input->getRows());
        $this->assertInstanceOf(Textarea::class, $input->setRows(5));
        $this->assertSame(5, $input->getRows());
    }
}
