<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [ 'status', 'description' ];

    public array $statusOptions = [
        'P' => 'Pendente, Aguardando Professor',
        'A' => 'Aguardando Aluno',
        'C' => 'Finalizado',
    ];
}
