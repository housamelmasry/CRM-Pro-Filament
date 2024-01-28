<?php

namespace App\Filament\App\Widgets;

use App\Models\Employee;
use Flowframe\Trend\Trend;
use Filament\Facades\Filament;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class EmployeesAppChart extends ChartWidget
{
    protected static ?string $heading = 'Employee Chart';

    protected static ?int $sort = 2;

    protected static string $color = 'primary';

    protected function getData(): array
    {
        $data = Trend::query(Employee::query()->whereBelongsTo(Filament::getTenant()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'Label' => 'Employees',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
