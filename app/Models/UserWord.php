<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserWord extends Model
{
    use HasFactory;

    protected $table = 'user_words';

    protected $fillable = [
        'ru',
        'eng'
    ];

    public function user() :\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
