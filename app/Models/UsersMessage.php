<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersMessage extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}