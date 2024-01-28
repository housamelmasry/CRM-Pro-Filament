<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use App\Models\Project;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Builder;


class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()->badge(Project::query()->count()),
            'To Do' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=' , 'todo'))
                ->badge(Project::query()->where('status', '=', 'todo')->count())
                ->badgeColor('gray'),
            'In Progress' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=' , 'progress'))
                ->badge(Project::query()->where('status', '=', 'progress')->count())
                ->badgeColor('info'),
            'Done' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=' , 'done' ))
                ->badge(Project::query()->where('status', '=', 'done')->count())
                ->badgeColor('success'),
        ];
}
}
