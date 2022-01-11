<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Exception;
use Livewire\Livewire;
use Nodus\Packages\LivewireForms\Livewire\FormView;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Nodus\Packages\LivewireForms\Tests\data\InputTestForm;
use Nodus\Packages\LivewireForms\Tests\data\models\User;
use Nodus\Packages\LivewireForms\Tests\data\UserTestCreateUpdateForm;
use Nodus\Packages\LivewireForms\Tests\data\UserTestForm;
use Nodus\Packages\LivewireForms\Tests\data\UserTestSubmitForm;

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
            ->assertHasNoErrors(['values.min_input' => 'min'])
            ->set('values.required_input', 'fail')
            ->call('onSubmit')
            ->assertSessionHas('validation-errors', [0 =>'required_input']);
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

    public function testBasicSubmitCreate()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        Livewire::test(UserTestForm::class, ['modelOrArray' => new User(), 'postMode' => FormView::POST_MODE_CREATE])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_CREATE)
            ->call('onSubmit');
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
    }

    public function testBasicSubmitUpdate()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        Livewire::test(UserTestForm::class, ['modelOrArray' => User::factory()->create()])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_UPDATE)
            ->call('onSubmit');
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
    }

    public function testBasicSubmitException()
    {
        $this->expectException(Exception::class);
        Livewire::test(UserTestForm::class)
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_CREATE)
            ->call('onSubmit');
    }

    public function testCustomSubmitCreate()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        Livewire::test(UserTestCreateUpdateForm::class, ['modelOrArray' => new User(), 'postMode' => FormView::POST_MODE_CREATE])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_CREATE)
            ->call('onSubmit')
            ->assertSuccessful();
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
    }

    public function testCustomSubmitUpdate()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        Livewire::test(UserTestCreateUpdateForm::class, ['modelOrArray' => User::factory()->create()])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_UPDATE)
            ->call('onSubmit')
            ->assertSuccessful();
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
    }

    public function testCustomSubmit()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        $component = Livewire::test(UserTestSubmitForm::class, ['modelOrArray' => new User(), 'postMode' => FormView::POST_MODE_CREATE])
            ->set('values.first_name', 'John')
            ->set('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_CREATE)
            ->call('onSubmit')
            ->assertSuccessful();
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);

        $values = $component->instance()->getValues();
        $this->assertArrayHasKey('first_name', $values);
        $this->assertEquals('mail@example.de', $values['email']);
    }

    public function testButtonLabel()
    {
        Livewire::test(UserTestForm::class)
            ->assertDontSee('Custom Button Label')
            ->call('setSaveButtonLabel', 'Custom Button Label')
            ->assertSee('Custom Button Label');
    }

    public function testButtonClasses()
    {
        Livewire::test(UserTestForm::class)
            ->assertDontSeeHtml('class="btn-custom-class btn-custom-class2"')
            ->call('setSaveButtonClasses', 'btn-custom-class')
            ->assertSeeHtml('class="btn-custom-class"')
            ->call('addSaveButtonClasses', 'btn-custom-class2')
            ->assertSeeHtml('class="btn-custom-class btn-custom-class2"');
    }

    public function testButtonIconClass()
    {
        Livewire::test(UserTestForm::class)
            ->assertDontSeeHtml('<i class="icon icon-save"></i>')
            ->call('setSaveButtonIconClasses', 'icon icon-save')
            ->assertSeeHtml('<i class="icon icon-save"></i>');
    }

    public function testArrayInitialization()
    {
        $this->assertDatabaseMissing('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
        Livewire::test(UserTestSubmitForm::class, ['modelOrArray' => ['first_name' => 'John', 'email' => 'mail@example.de'], 'postMode' => FormView::POST_MODE_CREATE])
            ->assertSet('values.first_name', 'John')
            ->assertSet('values.email', 'mail@example.de')
            ->assertSet('postMode', FormView::POST_MODE_CREATE)
            ->call('onSubmit')
            ->assertSuccessful();
        $this->assertDatabaseHas('users', ['first_name' => 'John', 'email' => 'mail@example.de']);
    }

    public function testWrongInitializationException()
    {
        $this->expectException(Exception::class);
        Livewire::test(UserTestForm::class, ['modelOrArray' => 1]);
    }
}