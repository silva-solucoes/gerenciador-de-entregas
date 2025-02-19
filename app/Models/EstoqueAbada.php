<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueAbada extends Model
{
    use HasFactory;

    protected $table = 'estoque_abadas';

    protected $fillable = [
        'tamanho',
        'quantidade'
    ];

    public function entregas()
    {
        return $this->hasMany(LogEntrega::class, 'tamanho_abada', 'tamanho');
    }
}
