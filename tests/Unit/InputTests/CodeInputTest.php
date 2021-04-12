<?php

namespace Tests\Unit\InputTests;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Code;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Tests\Unit\TestCase;

class CodeInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Code('code_input');

        $this->assertSame('code_input',$input->getLabel());
        $this->assertSame('code_input',$input->getId());
        $this->assertSame('code_input',$input->getName());
        $this->assertSame('code',$input->getType());
        $this->assertSame('values.code_input',$input->getViewId());
        $this->assertSame(null,$input->getHint());
        $this->assertSame('',$input->getValidations());
        $this->assertSame(6,$input->getSize());
        $this->assertSame(null,$input->getDefaultValue());
        $this->assertSame(null,$input->getValue());
    }

    public function testMode()
    {
        $input = new Code('code_input');
        $this->assertSame(null,$input->getMode());
        $input->setMode('css');
        $this->assertSame('css',$input->getMode());
    }
}