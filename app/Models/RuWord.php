<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuWord extends Model
{
    use HasFactory;

    protected $table = 'ru';
    protected $fillable = ['word', 'audio', 'spelling'];

    public function eng() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(EngWord::class);
    }
}
