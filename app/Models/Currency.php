<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $price
 */
class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price'];

    public function currencyLog(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CurrencyLog::class);
    }
}
