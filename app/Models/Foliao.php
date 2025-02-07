<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foliao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'cpf',
    ];

    // Relacionamento: Um folião pode ter uma entrega registrada
    public function logEntrega()
    {
        return $this->hasOne(LogEntrega::class, 'foliao_id');
    }
}
