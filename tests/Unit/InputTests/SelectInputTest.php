<?php

    namespace Tests\Unit\InputTests;

    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\ValidationException;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
    use Tests\Unit\TestCase;

    class SelectInputTest extends TestCase
    {
        public function testDefaults()
        {
            $input = new Select('select_input');

            $this->assertSame('select_input',$input->getLabel());
            $this->assertSame('select_input',$input->getId());
            $this->assertSame('select_input',$input->getName());
            $this->assertSame('select',$input->getType());
            $this->assertSame('values.select_input',$input->getViewId());
            $this->assertSame(null,$input->getHint());
            $this->assertSame('',$input->getValidations());
            $this->assertSame(6,$input->getSize());
            $this->assertSame(null,$input->getDefaultValue());
            $this->assertSame(null,$input->getValue());
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

            $this->assertSame(null,$input->preRenderMutator(null));
            $this->assertSame(null,$input->preRenderMutator(''));

            $input->setOptions($options);

            $this->assertSame(0,$input->preRenderMutator(null));
            $this->assertSame(0,$input->preRenderMutator(''));
            $this->assertSame(1,$input->preRenderMutator(1));

            // Multi select
            $input->setMultiple();
            $this->assertSame([],$input->preRenderMutator(null));
            $this->assertSame([1],$input->preRenderMutator(1));
            $this->assertSame([1],$input->preRenderMutator([1]));
        }

        public function testPostValidationMutator()
        {
            $input = new Select('select_input');

            $this->assertSame(null, $input->postValidationMutator(null));
            $this->assertSame('', $input->postValidationMutator(''));
            $this->assertSame(1, $input->postValidationMutator(1));
            $this->assertSame(null, $input->postValidationMutator((string)Select::NULL_OPTION));
            $this->assertSame(null, $input->postValidationMutator(Select::NULL_OPTION));
        }

        public function testRequiredOptionValidationRule()
        {
            $this->assertArrayHasKey('input', Validator::validate(['input' => 0], ['input' => 'required_option']));
            $this->expectException(ValidationException::class);
            $this->assertArrayHasKey('input', Validator::validate(['input' => Select::FORCE_OPTION], ['input' => 'required_option']));
        }
    }