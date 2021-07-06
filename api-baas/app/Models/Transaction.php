<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use Uuid, SoftDeletes, HasFactory;

    /**
     * Indicates table name.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_from',
        'wallet_to',
        'status',
        'total',
        'gateway_code',
    ];

    public function payer()
    {
        return $this->belongsTo(Wallet::class, 'wallet_from', 'id');
    }

    public function payee()
    {
        return $this->belongsTo(Wallet::class, 'wallet_to', 'id');
    }
}
