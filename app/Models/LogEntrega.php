<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEntrega extends Model
{
    use HasFactory;

    protected $table = 'logs_entregas'; // Nome correto da tabela

    protected $fillable = [
        'foliao_id',
        'user_id',
        'data_entrega',
    ];

    // Relacionamento: Cada log pertence a um folião
    public function foliao()
    {
        return $this->belongsTo(Foliao::class);
    }

    // Relacionamento: Cada log pertence a um operador (usuário)
    public function operador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
