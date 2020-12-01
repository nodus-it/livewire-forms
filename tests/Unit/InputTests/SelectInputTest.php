<?php

    namespace Tests\Unit\InputTests;

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

        public function testSetValues()
        {
            $input = new Select('select_input');
            $options = [0 => Select::option('test_label')];

            $this->assertSame([],$input->getValues());
            $this->assertInstanceOf(Select::class, $input->setValues($options));
            $this->assertSame($options,$input->getValues());
        }

        public function testSetForceOption()
        {
            $options = [0 => Select::option('test_label')];
            $input = Select::create('select_input')->setValues($options);


            $this->assertSame($options,$input->getValues());
            $this->assertInstanceOf(Select::class, $input->setForceOption());
            $this->assertArrayHasKey(Select::FORCE_OPTION,$input->getValues());
            $this->assertSame(Select::FORCE_OPTION,$input->getDefaultValue());
        }

        public function validTranslations()
        {
            return [
                ['DeselectAllText', 'deselect_all'],
                ['SelectAllText', 'select_all'],
                ['NoneSelectedText', 'none_selected'],
                ['NoneResultsText', 'none_results'],
            ];
        }

        /**
         * @dataProvider validTranslations
         */
        public function testTranslationSetter($method,$trans)
        {
            $input = Select::create('select_input');

            $this->assertSame(
                trans('nodus.packages.livewire-forms::forms.bootstrap_select.' . $trans),
                $input->{'get'.$method}()
            );
            $this->assertInstanceOf(Select::class, $input->{'set'.$method}('test_translation'));
            $this->assertSame(trans('test_translation'), $input->{'get'.$method}());
        }
    }