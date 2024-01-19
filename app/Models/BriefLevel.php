<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BriefLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'number'
    ];

    public function briefs(): HasMany
    {
        return $this->hasMany(Brief::class);
    }
}
