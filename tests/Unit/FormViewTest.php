<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Livewire\Livewire;
use Nodus\Packages\LivewireForms\Livewire\FormView;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Tests\data\InputTestForm;
use Nodus\Packages\LivewireForms\Tests\data\models\User;
use Nodus\Packages\LivewireForms\Tests\data\UserTestForm;

class FormViewTest extends TestCase
{
    public function testValueInitialization()
    {
        $component = Livewire::test(InputTestForm::class);

        $component->runAction('render');

        $this->assertArrayHasKey('text_input', $component->payload[ 'serverMemo' ][ 'data' ][ 'values' ]);
        $this->assertNull($component->payload[ 'serverMemo' ][ 'data' ][ 'values' ][ 'text_input' ]);
        $this->assertArrayHasKey('select_input', $component->payload[ 'serverMemo' ][ 'data' ][ 'values' ]);
        $this->assertNull($component->payload[ 'serverMemo' ][ 'data' ][ 'values' ][ 'select_input' ]);
        $this->assertArrayNotHasKey('select_input2', $component->payload[ 'serverMemo' ][ 'data' ][ 'values' ]);
    }

    public function testDefaultValues()
    {
        Livewire::test(InputTestForm::class)
            ->runAction('render')
            ->assertSet('values.default_input', 'Thats the default')
            ->assertPayloadSet('values.default_input', 'Thats the default');
    }

    public function testValidationMessages()
    {
        Livewire::test(InputTestForm::class)
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

    public function testGetInput()
    {
        $view = new class() extends FormView {
            public function inputs()
            {
                $this->addText('text_input');
            }
        };
        $view->inputs();

        $this->assertInstanceOf(Text::class, $view->getInput('text_input'));
        $this->assertNull($view->getInput('not_defined_input'));
    }

    public function testMacroableSupport()
    {
        FormView::macro(
            'addNewCustomInput',
            function (string $name, string $label = null) {
                return $this->addInput(Text::class, $name, $label);
            }
        );

        $view = new class() extends FormView {
            public function inputs()
            {
                $this->addNewCustomInput('test_custom');
            }
        };
        $view->inputs();

        $this->assertInstanceOf(Text::class, $view->getInput('test_custom'));
    }

    public function testBasicSubmit()
    {
        Livewire::test(UserTestForm::class, ['modelOrArray' => User::factory()->create()])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->call('onSubmit');
    }
}