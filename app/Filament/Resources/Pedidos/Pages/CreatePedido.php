<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use App\Notifications\PedidoCriadoNotification;
use Filament\Resources\Pages\CreateRecord;

class CreatePedido extends CreateRecord
{
    protected static string $resource = PedidoResource::class;

    protected function afterCreate(): void
    {
        $pedido = $this->record;

        $total = $pedido->itens->sum(function ($item) {
            return $item->quantidade * $item->preco_unitario;
        });

        $pedido->update(['total' => $total]);
        $pedido->refresh();

        // Dispara o email de confirmação ao cliente associado ao pedido
        if ($pedido->cliente?->email) {
            $pedido->cliente->notify(new PedidoCriadoNotification($pedido));
        }
    }
}

