<?php

namespace Nodus\Packages\LivewireForms\Tests\Data;

use Illuminate\Database\Eloquent\Model;
use Nodus\Packages\LivewireForms\Tests\Data\Models\User;

class UserTestCreateUpdateForm extends UserTestForm
{
    public function submitCreate(array $values): mixed
    {
        User::query()->create($values);

        return null;
    }

    public function submitUpdate(array $values, Model $model): mixed
    {
        $model->update($values);

        return null;
    }
}
