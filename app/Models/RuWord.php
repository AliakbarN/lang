<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuWord extends Model
{
    use HasFactory;

    protected $table = 'ru_word';
    protected $fillable = ['word', 'trns'];

    public function engWords() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(EngWord::class);
    }
}
