<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ProjectResource\Pages;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Projects Management';

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
                Forms\Components\Select::make('employee_id')
                    ->relationship('user', 'name')
                    ->label('Project Manager')
                    ->native(false),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->native(false),
                Forms\Components\Select::make('partner_id')
                    ->relationship('partner', 'name')
                    ->label('Partner')
                    ->native(false),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->label('Client')
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
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_Date')
                    ->date()
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Section::make('Project INFO')
                    ->description('project info')
                    ->schema([
                        TextEntry::make('title')->columnSpan(1)
                            ->label('Project title'),
                        TextEntry::make('user.name'),
                        TextEntry::make('client.name'),
                        TextEntry::make('description')
                            ->columnSpan(2),
                        TextEntry::make('start_Date')->date(),
                        TextEntry::make('end_Date')->date(),
                        TextEntry::make('priority')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'high' => 'danger',
                                'medium' => 'warning',
                                'low' => 'info',
                            }),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'todo' => 'gray',
                                'progress' => 'info',
                                'done' => 'success',
                            }),
                    ])->columnSpan(1),
                Section::make('Project Details')
                    ->description('Project Details')
                    ->schema([
                        TextEntry::make('location'),
                        TextEntry::make('type'),
                        TextEntry::make('department.name'),
                        TextEntry::make('created_at'),
                        TextEntry::make('updated_at'),
                    ])->columnSpan(1),
                Section::make('Media')
                    ->description('Images used in the page layout.')
                    ->schema([
                        // ...
                    ]),
                // TextEntry::getDescriptionBelow('description'),
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
