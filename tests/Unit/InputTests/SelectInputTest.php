<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class SelectInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Select('select_input');

        $this->assertSame('select_input', $input->getLabel());
        $this->assertSame('select_input', $input->getId());
        $this->assertSame('select_input', $input->getName());
        $this->assertSame('select', $input->getType());
        $this->assertSame('values.select_input', $input->getViewId());
        $this->assertSame(null, $input->getHint());
        $this->assertSame('', $input->getValidations());
        $this->assertSame(6, $input->getSize());
        $this->assertSame(null, $input->getDefaultValue());
        $this->assertSame(null, $input->getValue());
    }

    public function testOptions()
    {
        $this->assertSame(['label' => 'test_label', 'icon' => null], Select::option('test_label'));
        $this->assertSame(['label' => 'test_label', 'icon' => 'fa-star'], Select::option('test_label', 'fa-star'));
    }

    public function testCastNullSelectOptions()
    {
        $options = [
            [0 => Select::option('test_label')],
            ['' => Select::option('test_label2')],
        ];

        $this->assertArrayHasKey(0, Select::castNullSelectOptions($options[0]));
        $this->assertArrayNotHasKey(Select::NULL_OPTION, Select::castNullSelectOptions($options[0]));

        $this->assertArrayNotHasKey('', Select::castNullSelectOptions($options[1]));
        $this->assertArrayHasKey(Select::NULL_OPTION, Select::castNullSelectOptions($options[1]));
    }

    public function testSetOptions()
    {
        $input = new Select('select_input');
        $options = [0 => Select::option('test_label')];

        $this->assertSame([], $input->getOptions());
        $this->assertInstanceOf(Select::class, $input->setOptions($options));
        $this->assertSame($options, $input->getOptions());
    }

    public function testSetDefault()
    {
        $input = new Select('select_input');
        $options = [0 => Select::option('test_label')];

        $this->assertInstanceOf(Select::class, $input->setOptions($options));
        $input->setDefaultValue(0);
        $this->assertSame(0, $input->getValue());
        $input->setDefaultValue(1);
        $this->assertSame(null, $input->getValue());
    }

    public function testSetForceOption()
    {
        $options = [0 => Select::option('test_label')];
        $input = Select::create('select_input')->setOptions($options);

        $this->assertSame($options, $input->getOptions());
        $this->assertInstanceOf(Select::class, $input->setForceOption());
        $this->assertArrayHasKey(Select::FORCE_OPTION, $input->getOptions());
        $this->assertSame(Select::FORCE_OPTION, $input->getDefaultValue());
        $this->assertSame(true, $input->getForceOption());
        $this->assertStringContainsString('required_option', $input->rewriteValidationRules());

        $input = Select::create('select_input')
            ->setOptions($options)
            ->setForceOption()
            ->setValidations('required');
        $this->assertStringContainsString('|required_option', $input->rewriteValidationRules());
    }

    public function testPreRenderMutator()
    {
        // Single select
        $input = new Select('select_input');
        $options = [
            0 => Select::option('test_label1'),
            1 => Select::option('test_label2')
        ];

        $this->assertSame(null, $input->preRenderMutator(null));
        $this->assertSame(null, $input->preRenderMutator(''));

        $input->setOptions($options);

        $this->assertSame(0, $input->preRenderMutator(null));
        $this->assertSame(0, $input->preRenderMutator(''));
        $this->assertSame(1, $input->preRenderMutator(1));

        // Multi select
        $input->setMultiple();
        $this->assertSame([], $input->preRenderMutator(null));
        $this->assertSame([1], $input->preRenderMutator(1));
        $this->assertSame([1], $input->preRenderMutator([1]));
    }

    public function testPreValidationMutator()
    {
        $input = new Select('select_input');

        $this->assertSame(null, $input->preValidationMutator(null));
        $this->assertSame(null, $input->preValidationMutator(''));
        $this->assertSame(null, $input->preValidationMutator(1));
        $this->assertSame(null, $input->preValidationMutator((string)Select::NULL_OPTION));
        $this->assertSame(null, $input->preValidationMutator(Select::NULL_OPTION));
        $this->assertSame(null, $input->preValidationMutator(Select::FORCE_OPTION));
        $this->assertSame(null, $input->preValidationMutator('x'));

        $input->setOptions(['x' => Select::option('x'), 'y' => Select::option('y')]);

        $this->assertSame(null, $input->preValidationMutator(null));
        $this->assertSame(null, $input->preValidationMutator(''));
        $this->assertSame(null, $input->preValidationMutator(1));
        $this->assertSame(null, $input->preValidationMutator((string)Select::NULL_OPTION));
        $this->assertSame(null, $input->preValidationMutator(Select::NULL_OPTION));
        $this->assertSame(null, $input->preValidationMutator(Select::FORCE_OPTION));
        $this->assertSame('x', $input->preValidationMutator('x'));
        $this->assertSame('y', $input->preValidationMutator('y'));

        $input->setForceOption();
        $this->assertSame(Select::FORCE_OPTION, $input->preValidationMutator(Select::FORCE_OPTION));

        $input->setMultiple();
        $this->assertSame([], $input->preValidationMutator(null));
        $this->assertSame([], $input->preValidationMutator(''));
        $this->assertSame([], $input->preValidationMutator(1));
        $this->assertSame([null], $input->preValidationMutator((string)Select::NULL_OPTION));
        $this->assertSame([null], $input->preValidationMutator([Select::NULL_OPTION]));
        $this->assertSame([], $input->preValidationMutator(Select::FORCE_OPTION));
        $this->assertSame(['x'], $input->preValidationMutator(['x']));
        $this->assertSame(['x', 'y'], $input->preValidationMutator(['x', 'y']));
        $this->assertSame(['x', 'y'], $input->preValidationMutator([Select::FORCE_OPTION, 'x', 'y', 'z']));
    }

    public function testRequiredOptionValidationRule()
    {
        $this->assertArrayHasKey('input', Validator::validate(['input' => 0], ['input' => 'required_option']));
        $this->expectException(ValidationException::class);
        $this->assertArrayHasKey('input', Validator::validate(['input' => Select::FORCE_OPTION], ['input' => 'required_option']));
    }
}
