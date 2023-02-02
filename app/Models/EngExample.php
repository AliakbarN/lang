<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngExample extends Model
{
    use HasFactory;

    protected $table = 'eng_example';

    protected $fillable = ['text', 'translation'];

    public function eng() :\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(App\Models\EngWord::class);
    }
}
