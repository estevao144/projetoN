<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContaBancaria;

class StatusTransacao extends Model
{
    use HasFactory;

    protected $table = 'status_transacao';

    protected $fillable = [
        'status',
        'descricao'
    ];

    public function transacao()
    {
        return $this->hasMany(ContaBancaria::class);
    }
}
