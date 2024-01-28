<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatesAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())
                ->description('All users from this application')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 30, 10, 3, 15, 4, 17, 44])
                ->color('success'),
            Stat::make('Departments', Department::query()->count())
                ->description('All Departments in this application')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->descriptionColor('danger')
                ->chart([7, 2, 10, 3, 15, 90, 17, 12])
                ->color('danger'),
            Stat::make('Teams', Team::query()->count())
                ->description('All Teams in this application')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->descriptionColor('danger')
                ->chart([7, 2, 10, 70, 15, 4, 17, 12])
                ->color('danger'),
            Stat::make('Employees', Employee::query()->count())
                ->description('All Employee in this application')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionColor('success')
                ->chart([7, 2, 10, 3, 15, 4, 17, 33])
                ->color('success'),
        ];
    }
}
