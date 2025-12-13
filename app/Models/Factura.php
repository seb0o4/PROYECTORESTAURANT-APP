<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'user_id',
        'pedido_id',
        'subtotal',
        'impuestos',
        'total',
        'estado',
        'fecha_emision',
        'fecha_vencimiento',
        'concepto',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
        'fecha_emision' => 'datetime',
        'fecha_vencimiento' => 'datetime',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}