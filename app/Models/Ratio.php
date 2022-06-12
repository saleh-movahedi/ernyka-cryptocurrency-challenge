<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Currency $currencyA
 * @property Currency $currencyB
 * @property mixed $value
 */
class Ratio extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'currency_a_id', 'currency_b_id', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currencyA(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_a_id');
    }

    public function currencyB(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_b_id');
    }
}
