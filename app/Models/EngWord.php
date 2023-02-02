<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngWord extends Model
{
    use HasFactory;

    protected $table = 'eng';
    protected $fillable = ['word', 'audio', 'spelling'];

    public function ru() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RuWord::class);
    }

    public function eng_example() :\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\EngExample::class);
    }
}
