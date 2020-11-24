<?php

    namespace Tests\Unit;

    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\ViewErrorBag;
    use Livewire\Component;
    use Livewire\Livewire;
    use Nodus\Packages\LivewireForms\Livewire\FormView;

    class BaseTest extends TestCase
    {
        /** @test */
        public function validate_values_initialization()
        {
            $component = Livewire::test(ForValidation::class);

            $component->runAction('render');

            $this->assertArrayHasKey('text_input', $component->payload['serverMemo']['data']['values']);
            $this->assertNull($component->payload['serverMemo']['data']['values']['text_input']);
            $this->assertArrayHasKey('select_input', $component->payload['serverMemo']['data']['values']);
            $this->assertNull($component->payload['serverMemo']['data']['values']['select_input']);
            $this->assertArrayNotHasKey('select_input2', $component->payload['serverMemo']['data']['values']);
        }

        /** @test */
        public function validate_default_values()
        {
            Livewire::test(ForValidation::class)
                ->runAction('render')

                ->assertSet('values.default_input', 'Thats the default')
                ->assertPayloadSet('values.default_input', 'Thats the default');
        }

        /** @test */
        public function validate_validation_messages()
        {
            Livewire::test(ForValidation::class)
                ->runAction('render')
                ->set('values.required_input', '')
                ->assertHasErrors(['values.required_input' => 'required'])
                ->set('values.required_input', 'test')
                ->assertHasNoErrors(['values.required_input' => 'required']);
        }
    }

    class ForValidation extends FormView {

        public function inputs()
        {
            $this->addText('text_input');
            $this->addSelect('select_input');

            $this->addText('default_input')
                ->setDefaultValue('Thats the default');

            $this->addText('required_input')
                ->setValidations('required');
            $this->addText('min_input')
                ->setValidations('required|min:5');
        }
    }