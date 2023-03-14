<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Decimal;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\Currency;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class DecimalInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Decimal('decimal_input');

        $this->assertSame('decimal_input', $input->getLabel());
        $this->assertSame('decimal_input', $input->getId());
        $this->assertSame('decimal_input', $input->getName());
        $this->assertSame('decimal', $input->getType());
        $this->assertSame('values.decimal_input', $input->getViewId());
        $this->assertSame(null, $input->getHint());
        $this->assertSame('', $input->getValidations());
        $this->assertSame(6, $input->getSize());
        $this->assertSame(0.0, $input->getDefaultValue());
        $this->assertSame(0.0, $input->getValue());
        $this->assertSame(Currency::Euro, $input->getUnit());
        $this->assertSame(2, $input->getDecimals());
    }

    public function testPreValidationMutator()
    {
        $input = new Decimal('decimal_input');

        $this->assertSame(0.0, $input->preValidationMutator(''));
    }

    public function testParseValue()
    {
        $this->assertSame(0.0, Decimal::parseValue(0));
        $this->assertSame(10.5, Decimal::parseValue(10.5));

        $this->assertSame(0.0, Decimal::parseValue(''));
        $this->assertSame(0.0, Decimal::parseValue('0'));
        $this->assertSame(5.0, Decimal::parseValue('5'));
        $this->assertSame(10.5, Decimal::parseValue('10,5'));
        $this->assertSame(1500.0, Decimal::parseValue('1.500'));
        $this->assertSame(1234.56, Decimal::parseValue('1.234,56 €'));
    }

    public function testPreRenderMutator()
    {
        $unit = "\xc2\xa0€";
        $input = new Decimal('decimal_input');

        $this->assertSame('0,00' . $unit, $input->preRenderMutator(null));
        $this->assertSame('0,00' . $unit, $input->preRenderMutator(''));
        $this->assertSame('0,00' . $unit, $input->preRenderMutator('0'));
        $this->assertSame('1.234,56' . $unit, $input->preRenderMutator(1234.56));
        $this->assertSame('1.234,56' . $unit, $input->preRenderMutator('1.234,56 €'));

        $unit = ' %';
        $input->setUnit('%');
        $this->assertSame('0,00' . $unit, $input->preRenderMutator(null));
        $this->assertSame('0,00' . $unit, $input->preRenderMutator(''));
        $this->assertSame('0,00' . $unit, $input->preRenderMutator('0'));
        $this->assertSame('1.234,56' . $unit, $input->preRenderMutator(1234.56));
        $this->assertSame('1.234,56' . $unit, $input->preRenderMutator('1.234,56 €'));
    }

    public function testSetUnit()
    {
        $input = new Decimal('decimal_input');

        $this->assertSame(Currency::Euro, $input->getUnit());
        $this->assertInstanceOf(Decimal::class, $input->setUnit('USD'));
        $this->assertSame(Currency::US_Dollar, $input->getUnit());
        $this->assertInstanceOf(Decimal::class, $input->setUnit(Currency::Yuan_Renminbi));
        $this->assertSame(Currency::Yuan_Renminbi, $input->getUnit());
        $this->assertInstanceOf(Decimal::class, $input->setUnit(null));
        $this->assertSame(null, $input->getUnit());
    }

    public function testSetDecimals()
    {
        $input = new Decimal('decimal_input');

        $this->assertSame(2, $input->getDecimals());
        $this->assertInstanceOf(Decimal::class, $input->setDecimals(4));
        $this->assertSame(4, $input->getDecimals());
    }

    public function testFloatValidationRule()
    {
        $this->assertArrayHasKey('input', Validator::validate(['input' => '0'], ['input' => 'float']));
        $this->assertArrayHasKey('input', Validator::validate(['input' => '0.5'], ['input' => 'float']));
        $this->assertArrayHasKey('input', Validator::validate(['input' => '5.99'], ['input' => 'float']));
        $this->expectException(ValidationException::class);
        $this->assertArrayHasKey('input', Validator::validate(['input' => '5,99'], ['input' => 'float']));
        $this->assertArrayHasKey('input', Validator::validate(['input' => 'test'], ['input' => 'float']));
    }
}
