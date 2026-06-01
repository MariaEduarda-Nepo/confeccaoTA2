<?php

namespace App\Filament\Resources\MovimentacaoEstoqueResource\Pages;

use App\Filament\Resources\MovimentacaoEstoqueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMovimentacaoEstoque extends EditRecord
{
    protected static string $resource = MovimentacaoEstoqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}