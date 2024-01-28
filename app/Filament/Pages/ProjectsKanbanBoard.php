<?php

namespace App\Filament\Pages;

use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;


class ProjectsKanbanBoard extends KanbanBoard

{
    protected static string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Clients';

    protected string $editModalTitle = 'Edit Record';
    protected string $editModalWidth = '2xl';
    protected string $editModalSaveButtonLabel = 'Save';
    protected string $editModalCancelButtonLabel = 'Cancel';

    protected function statuses(): Collection
    {
        return collect([
            [
                'id' => 'todo',
                'title' => 'To Do',
            ],
            [
                'id' => 'progress',
                'title' => 'In progress',
            ],
            [
                'id' => 'done',
                'title' => 'Done',
            ],
        ]);
    }


    protected function records(): Collection
    {
        return Project::all();
    }


    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Project::find($recordId)->update(['status' => $status]);
        // Project::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        // Project::setNewOrder($orderedIds);
    }


    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title'),
            TextInput::make('description'),
            Select::make('priority')
            ->options([
                'low' => 'Low Priority',
                'medium' => 'Medium Priority',
                'high' => 'High Priority',
            ])
            ->native(false)
        ];
    }

    protected function editRecord($recordId, array $data, array $state): void
{
    Project::find($recordId)->update([
        'title' => $data['title'],
        'description' => $data['description'],
        'priority' => $data['priority'],
    ]);
}
}
