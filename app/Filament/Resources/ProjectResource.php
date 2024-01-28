<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProjectResource\Pages;
use Filament\Tables\Filters\SelectFilter;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Clients';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        // return '#ffffff';
        // return 'info';
        return static::getModel()::count() > 20 ? 'warning' : 'success';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->native(false),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->native(false),
                // Forms\Components\TextInput::make('client_id')
                //     ->nullable()
                //     ->relationship('client', 'name'),
                Forms\Components\TextInput::make('title')
                    ->label('Project title')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(300),
                Forms\Components\DateTimePicker::make('start_Date')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_Date')
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => 'Low Priority',
                        'medium' => 'Medium Priority',
                        'high' => 'High Priority',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'progress' => 'In Progress',
                        'done' => 'Done',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(45),

                Forms\Components\Select::make('department_id')
                    ->relationship(name: 'department', titleAttribute: 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Project title')
                    ->words(5)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('start_Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'info',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'todo' => 'gray',
                        'progress' => 'info',
                        'done' => 'success',
                    }),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Tables\Columns\TextColumn::getDescriptionBelow('description'),
            ])
            ->filters([
                SelectFilter::make('Client')
                    ->relationship('Client', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Client')
                    ->indicator('Client'),
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
