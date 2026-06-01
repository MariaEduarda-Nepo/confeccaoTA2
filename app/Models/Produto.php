<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Produto extends Model
{
    protected $guarded = [];

       public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoEstoque::class);
    }

    // Atualiza o estoque automaticamente
    public function atualizarEstoque(): void
    {
        $entradas = $this->movimentacoes()->where('tipo', 'entrada')->sum('quantidade');
        $saidas   = $this->movimentacoes()->where('tipo', 'saida')->sum('quantidade');

        $this->update(['estoque' => $entradas - $saidas]);
    }
}