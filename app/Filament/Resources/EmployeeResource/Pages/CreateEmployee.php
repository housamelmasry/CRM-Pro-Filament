<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Employee Created';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
               ->success()
               ->title('Employee created')
               ->body('New Employee created successfully');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
