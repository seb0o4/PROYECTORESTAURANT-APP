<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'estado',
        'notas',
        'items'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'items' => 'array'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}