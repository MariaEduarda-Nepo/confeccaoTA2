<?php

namespace App\Filament\Resources\Pedidos\Schemas;

use App\Models\Cliente;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PedidoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cliente_id')
                    ->label('Cliente')
                    ->required()
                    ->options(Cliente::pluck('nome', 'id')),
                Select::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'em_producao' => 'Em Produção',
                        'finalizado' => 'Finalizado',
                    ])
                    ->default('pendente')
                    ->required(),
                TextInput::make('total')
                    ->numeric()
                    ->prefix('R$')
                    ->readOnly(),
                Repeater::make('itens')
                    ->relationship('itens')
                    ->schema([
                        Select::make('produto_id')
                            ->relationship('produto', 'nome')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Produto')
                            ->columnSpan(2),
                        TextInput::make('quantidade')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('preco_unitario')
                            ->numeric()
                            ->prefix('R$')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularTotal($get, $set))
                    ->label('Itens do Pedido'),
            ]);
    }

    public static function calcularTotal(Get $get, Set $set): void
    {
        $itens = $get('itens') ?? [];
        $total = 0;

        foreach ($itens as $item) {
            $quantidade = (float) ($item['quantidade'] ?? 0);
            $precoUnitario = (float) ($item['preco_unitario'] ?? 0);
            $total += $quantidade * $precoUnitario;
        }

        $set('total', number_format($total, 2, '.', ''));
    }
}
