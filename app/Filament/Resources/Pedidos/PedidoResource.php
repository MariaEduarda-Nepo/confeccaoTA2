<?php

namespace App\Filament\Resources\Pedidos;

use App\Filament\Resources\Pedidos\Pages\CreatePedido;
use App\Filament\Resources\Pedidos\Pages\EditPedido;
use App\Filament\Resources\Pedidos\Pages\ListPedidos;
use App\Filament\Resources\Pedidos\Pages\ViewPedido;
use App\Filament\Resources\Pedidos\Schemas\PedidoForm;
use App\Filament\Resources\Pedidos\Schemas\PedidoInfolist;
use App\Filament\Resources\Pedidos\Tables\PedidosTable;
use App\Models\Pedido;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Support\View\Components\Contracts\HasDefaultGrayColor;
use Filamente\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

use function Laravel\Prompts\select;
use function Livewire\after;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pedido';

    public static function form(Schema $schema): Schema
    {
        return PedidoForm::configure($schema);
        return $schema
            ->schema([
                Select::make('cliente_id')
                    ->relationship('cliente', 'nome')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Selecione o Cliente'),

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
                    ->prefix('R$'),



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
                        ->numeric(1)
                        ->default(1)
                        ->required()
                        ->columnSpan(1)
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularTotal($get, $set))
                        ->columnSpan(1),

                    TextInput::make('preco_unitario')
                        ->numeric()
                        ->prefix('R$')
                        ->required()
                        ->columnSpan(1),
                ])
                ->columns(4)
                ->columnSpanFull()
                ->label('Itens do Pedido')
            ]);

    }

    public static function infolist(Schema $schema): Schema
    {
        return PedidoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PedidosTable::configure($table);

        return $table
            ->columns([
                TextColumn::make('cliente.nome')
                    ->searchable()
                    ->label('Cliente')
                    ->sortable() ,

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pendente' => 'warning',
                        'em_producao' => 'info',
                        'finalizado' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('valor_total')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),



                TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
            ])

            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPedidos::route('/'),
            'create' => CreatePedido::route('/create'),
            'view' => ViewPedido::route('/{record}'),
            'edit' => EditPedido::route('/{record}/edit'),
        ];
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

        $set('valor_total', number_format($total, 2, '.', ''));
    }
}
