<?php

namespace Nodus\Packages\LivewireForms\Tests\Data;

use Illuminate\Database\Eloquent\Model;
use Nodus\Packages\LivewireForms\Tests\Data\Models\User;

class UserTestSubmitForm extends UserTestForm
{
    public function submit(array $values)
    {
        if ($this->isCreateMode()) {
            User::query()->create($values);
        } else {
            $this->getModel()->update($values);
        }
    }
}
