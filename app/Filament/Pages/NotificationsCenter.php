<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;

class NotificationsCenter extends Page
{
    // navigationIcon removido por compatibilidade com versão do Filament

    public $notifications = [];

    public function mount(): void
    {
        $this->notifications = [];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('teste')
                ->label('Teste')
                ->action(function () {
                    Notification::make()
                        ->title('Notificação')
                        ->body('Sistema de notificações preparado.')
                        ->success()
                        ->send();
                }),
        ];
    }
}

