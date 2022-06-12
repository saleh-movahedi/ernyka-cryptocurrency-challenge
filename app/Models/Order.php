<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User $user
 * @property mixed $user_id
 * @property Ratio $exchangeable
 * @property mixed $amount
 * @property mixed $id
 * @property mixed $type
 * @property mixed $exchangeable_id
 * @property mixed $tradable_ratio
 */
class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'exchangeable_id',
        'tradable_ratio',
        'amount',
        'status',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchangeable(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ratio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
