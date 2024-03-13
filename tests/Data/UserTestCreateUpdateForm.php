<?php

namespace Nodus\Packages\LivewireForms\Tests\Data;

use Illuminate\Database\Eloquent\Model;
use Nodus\Packages\LivewireForms\Tests\Data\Models\User;

class UserTestCreateUpdateForm extends UserTestForm
{
    public function submitCreate(array $values)
    {
        User::query()->create($values);
    }

    public function submitUpdate(array $values, Model $model)
    {
        $model->update($values);
    }
}