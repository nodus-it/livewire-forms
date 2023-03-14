<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Nodus\Packages\LivewireForms\Services\FormBuilder\DateTime;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class DateTimeInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new DateTime('datetime_input');

        $this->assertSame('datetime_input', $input->getLabel());
        $this->assertSame('datetime_input', $input->getId());
        $this->assertSame('datetime_input', $input->getName());
        $this->assertSame('datetime', $input->getType());
        $this->assertSame('values.datetime_input', $input->getViewId());
        $this->assertSame(null, $input->getHint());
        $this->assertSame('', $input->getValidations());
        $this->assertSame(6, $input->getSize());
        $this->assertSame(null, $input->getDefaultValue());
        $this->assertSame(
            [
                'date'     => null,
                'time'     => null,
                'datetime' => '',
            ],
            $input->getValue()
        );
        $this->assertSame(
            [
                'date'     => '2020-01-23',
                'time'     => '10:32',
                'datetime' => '2020-01-23 10:32',
            ],
            $input->getValue('23.01.2020 10:32:54')
        );
    }

    public function testPreValidationMutator()
    {
        $input = new DateTime('datetime_input');

        $this->assertSame(null, $input->preValidationMutator(null));
        $this->assertEquals(Carbon::create(2020, 01, 23, 10, 32, 54), $input->preValidationMutator(['datetime' => '23.01.2020 10:32:54']));

        $this->expectException(InvalidFormatException::class);
        $input->preValidationMutator(['datetime' => 'test']);
    }

    /*public function testPreRenderMutator()
    {
        $input = new DateTime('datetime_input');

        $this->assertSame(null,$input->preRenderMutator(null));
        $this->assertSame(null,$input->preRenderMutator(''));
        $this->assertSame('2020-01-23',$input->preRenderMutator('23.01.2020'));
        $this->assertSame('2020-01-23',$input->preRenderMutator('2020-01-23'));
        $this->assertSame('2020-01-23',$input->preRenderMutator(Carbon::createFromDate(2020,01,23)));
    }*/
}
