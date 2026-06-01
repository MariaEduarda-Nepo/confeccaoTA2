<?php

namespace App\Filament\Resources\MovimentacaoEstoque\Pages;

use App\Filament\Resources\MovimentacaoEstoqueResource;
use Filament\Actions\CreateAction;

use Filament\Resources\Pages\ListRecords;

class ListMovimentacaoEstoque extends ListRecords
{
    protected static string $resource = MovimentacaoEstoqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}