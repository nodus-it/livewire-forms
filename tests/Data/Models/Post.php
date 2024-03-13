<?php

namespace Nodus\Packages\LivewireForms\Tests\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nodus\Packages\LivewireForms\Tests\Data\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }
}
