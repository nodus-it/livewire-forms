<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Password;
use Nodus\Packages\LivewireForms\Tests\Unit\TestCase;

class PasswordInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Password('password_input');

        $this->assertSame('password_input', $input->getLabel());
        $this->assertSame('password_input', $input->getId());
        $this->assertSame('password_input', $input->getName());
        $this->assertSame('password', $input->getType());
        $this->assertSame('values.password_input', $input->getViewId());
        $this->assertSame(null, $input->getHint());
        $this->assertSame('', $input->getValidations());
        $this->assertSame(6, $input->getSize());
        $this->assertSame(null, $input->getDefaultValue());
        $this->assertSame(null, $input->getValue());
    }

    public function testSecureMode()
    {
        $input = new Password('password_input');
        $this->assertSame(null, $input->preRenderMutator(''));
        $this->assertSame('test1234', $input->preRenderMutator('test1234'));
        $this->assertInstanceOf(Password::class, $input->setSecure());
        $this->assertSame(null, $input->preRenderMutator('test1234'));
    }
}