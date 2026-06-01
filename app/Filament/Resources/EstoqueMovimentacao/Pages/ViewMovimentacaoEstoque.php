<?php

namespace App\Filament\Resources\MovimentacaoEstoque\Pages;

use App\Filament\Resources\MovimentacaoEstoque\MovimentacaoEstoqueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMovimentacaoEstoque extends ViewRecord
{
    protected static string $resource = MovimentacaoEstoqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
