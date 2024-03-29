<?php

namespace Nodus\Packages\LivewireForms\Tests\Data\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nodus\Packages\LivewireForms\Tests\Data\Database\Factories\UserFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'admin',
        'birthday',
    ];

    protected $dates = ['birthday'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function latestPost()
    {
        return $this->hasOne(Post::class)->latest();
    }

    public function methodCall()
    {
        return 'methodCallResult';
    }

    public function scopeAdmins(Builder $builder)
    {
        return $builder->where('admin', 1);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
