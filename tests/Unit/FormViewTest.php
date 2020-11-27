<?php

    namespace Tests\Unit;

    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\ViewErrorBag;
    use Livewire\Component;
    use Livewire\Livewire;
    use Nodus\Packages\LivewireForms\Livewire\FormView;

    class FormViewTest extends TestCase
    {
        public function testValueInitialization()
        {
            $component = Livewire::test(ForValidation::class);

            $component->runAction('render');

            $this->assertArrayHasKey('text_input', $component->payload['serverMemo']['data']['values']);
            $this->assertNull($component->payload['serverMemo']['data']['values']['text_input']);
            $this->assertArrayHasKey('select_input', $component->payload['serverMemo']['data']['values']);
            $this->assertNull($component->payload['serverMemo']['data']['values']['select_input']);
            $this->assertArrayNotHasKey('select_input2', $component->payload['serverMemo']['data']['values']);
        }

        public function testDefaultValues()
        {
            Livewire::test(ForValidation::class)
                ->runAction('render')

                ->assertSet('values.default_input', 'Thats the default')
                ->assertPayloadSet('values.default_input', 'Thats the default');
        }

        public function testValidationMessages()
        {
            Livewire::test(ForValidation::class)
                ->runAction('render')
                ->set('values.required_input', '')
                ->assertHasErrors(['values.required_input' => 'required'])
                ->set('values.required_input', 'test')
                ->assertHasNoErrors(['values.required_input' => 'required'])

                ->set('values.min_input', 'test')
                ->assertHasErrors(['values.min_input' => 'min'])
                ->set('values.min_input', 'test123')
                ->assertHasNoErrors(['values.min_input' => 'min']);
        }
    }

    class ForValidation extends FormView {

        public function inputs()
        {
            $this->addCheckbox('checkbox_input');
            $this->addColor('color_input');
            $this->addDate('date_input');
            $this->addDateTime('date_time_input');
            $this->addDecimal('decimal_input');
            $this->addFile('file_input');
            $this->addHidden('hidden_input','');
            $this->addNumber('number_input');
            $this->addPassword('password_input');
            $this->addRichTextarea('rich_textarea_input');
            $this->addSelect('select_input');
            $this->addText('text_input');
            $this->addTextarea('textarea_input');
            $this->addTime('time_input');

            $this->addText('default_input')
                ->setDefaultValue('Thats the default');

            $this->addText('required_input')
                ->setValidations('required');
            $this->addText('min_input')
                ->setValidations('required|min:5');
        }
    }