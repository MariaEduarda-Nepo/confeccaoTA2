<?php

namespace App\Filament\Resources\Notifications;

use App\Filament\Resources\Notifications\Pages\ListNotifications;
use Filament\Resources\Resource;

class NotificationResource extends Resource
{
    protected static ?string $model = null;

    // navigationIcon removido por compatibilidade com versão do Filament


    // navigationGroup removido por compatibilidade com versão do Filament


    public static function getPages(): array
    {
        return [
            'index' => ListNotifications::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Notificações';
    }
}

