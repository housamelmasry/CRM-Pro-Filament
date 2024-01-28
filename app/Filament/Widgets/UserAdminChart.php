<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Users Chart';

    protected static ?int $sort = 2;

    // protected function getData(): array
    // {
    //     return [
    //         'datasets' => [
    //             [
    //             'label' => 'Blog posts created',
    //             'data' => [33, 10, 5, 18, 21, 32, 45, 74, 65, 45,77],
    //             'backgroundColor' => ['#36A2EB'],
    //             'borderColor' => '#9BD0F5',
    //             ],
    //         ],
    //             'labels' => ['Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    //     ];
    // }

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users',
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
