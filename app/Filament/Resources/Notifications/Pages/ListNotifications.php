<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Contracts\View\View;


class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;
}


