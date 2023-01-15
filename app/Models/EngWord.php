<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngWord extends Model
{
    use HasFactory;

    protected $table = 'eng_word';
    protected $fillable = ['word', 'trns'];

    public function ruWords() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RuWord::class);
    }
}
