<?php

namespace App\Filament\App\Widgets;

use App\Models\Team;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatesAppOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Team Users', Team::find(Filament::getTenant())->first()->members()->count())
            ->description('All users from this application')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17, 12])
            ->color('success'),
        Stat::make('Departments', Department::query()->whereBelongsTo(Filament::getTenant())->count())
            ->description('All Departments in this application')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->descriptionColor('danger')
            ->color('danger'),
        Stat::make('Employees', Employee::query()->whereBelongsTo(Filament::getTenant())->count())
            ->description('All Employee in this application')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->descriptionColor('success')
            ->color('success'),
        ];
    }
}
