<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // ==================== RELACIONES ====================

    /**
     * Relación: Un usuario puede tener muchas facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    /**
     * Relación: Un usuario puede tener muchos pedidos
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Relación: Un usuario puede tener muchas reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope para obtener solo clientes (no administradores)
     */
    public function scopeClientes($query)
    {
        return $query->where('role', '!=', 'admin')->orWhereNull('role');
    }

    /**
     * Scope para obtener usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo')->orWhereNull('estado');
    }

    /**
     * Scope para obtener usuarios inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    // ==================== MÉTODOS DE AYUDA ====================

    /**
     * Obtener el total gastado por el usuario en facturas pagadas
     */
    public function getTotalGastadoAttribute()
    {
        return $this->facturas()->where('estado', 'pagada')->sum('total');
    }

    /**
     * Obtener el número total de pedidos del usuario
     */
    public function getTotalPedidosAttribute()
    {
        return $this->pedidos()->count();
    }

    /**
     * Obtener el número total de reservas del usuario
     */
    public function getTotalReservasAttribute()
    {
        return $this->reservas()->count();
    }

    /**
     * Obtener el número total de facturas del usuario
     */
    public function getTotalFacturasAttribute()
    {
        return $this->facturas()->count();
    }

    /**
     * Obtener las facturas pendientes del usuario
     */
    public function facturasPendientes()
    {
        return $this->facturas()->where('estado', 'pendiente');
    }

    /**
     * Obtener las facturas pagadas del usuario
     */
    public function facturasPagadas()
    {
        return $this->facturas()->where('estado', 'pagada');
    }

    // ==================== MÉTODOS DE ESTADO ====================

    /**
     * Verificar si el usuario está activo
     */
    public function estaActivo()
    {
        return $this->estado === 'activo' || is_null($this->estado);
    }

    /**
     * Activar usuario
     */
    public function activar()
    {
        $this->update(['estado' => 'activo']);
        return $this;
    }

    /**
     * Desactivar usuario
     */
    public function desactivar()
    {
        $this->update(['estado' => 'inactivo']);
        return $this;
    }

    // ==================== MÉTODOS DE ROL ====================

    /**
     * Asignar rol de administrador
     */
    public function hacerAdmin()
    {
        $this->update(['role' => 'admin']);
        return $this;
    }

    /**
     * Asignar rol de cliente
     */
    public function hacerCliente()
    {
        $this->update(['role' => 'cliente']);
        return $this;
    }

    /**
     * Verificar si es cliente
     */
    public function isCliente()
    {
        return $this->role === 'cliente' || is_null($this->role);
    }
}