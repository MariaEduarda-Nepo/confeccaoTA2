<?php

namespace App\Filament\Resources\ItemPedidos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ItemPedidoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pedido_id')
                    ->required()
                    ->numeric(),
                TextInput::make('produto_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantidade')
                    ->required()
                    ->numeric(),
                TextInput::make('preco_unitario')
                    ->required()
                    ->numeric(),
            ]);
    }
}
