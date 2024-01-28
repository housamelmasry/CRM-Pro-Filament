<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use Filament\Facades\Filament;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }

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

                //start user information section
                Forms\Components\Section::make('User Name')
                    ->description('Put the user name details in.')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                    ])->columns(3),
                // end user information section


                //start address  section
                Forms\Components\Section::make('User address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zip_code')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                //end address  section


                //start dates section
                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required()
                            ->native(false),
                        Forms\Components\DatePicker::make('date_hired')
                            ->required()
                            ->native(false),
                    ])->columns(2),
                //end dates section

                //start employment section
                Forms\Components\Section::make('Employment')
                    ->description('Put the Employment details in.')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->required(),

                        Forms\Components\Select::make('state_id')
                            ->options(fn (Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                            ->required(),

                        Forms\Components\Select::make('city_id')
                            ->options(fn (Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),

                        Forms\Components\Select::make('department_id')
                            ->relationship(
                                name: 'department',
                                titleAttribute: 'name',
                                // department belongs to the same team
                                modifyQueryUsing: fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
                            )
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required(),
                        // Forms\Components\Select::make('team_id')
                        //     ->relationship(name: 'team', titleAttribute: 'name')
                        //     ->native(false)
                        //     ->searchable()
                        //     ->preload(),
                    ])->columns(4),
                //end employment section

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('city.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    //view section
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Emoployee Name')
                    ->schema([
                        TextEntry::make('first_name')->label('First Name'),
                        TextEntry::make('middle_name')->label('Middle Name'),
                        TextEntry::make('last_name')->label('Last Name'),
                    ])->columns(3),
                Section::make('Emoployee Info')
                    ->schema([
                        TextEntry::make('address')->label('Address'),
                        TextEntry::make('zip_code')->label('Zip Code'),
                        TextEntry::make('country.name')->label('Country'),
                        TextEntry::make('state.name')->label('State'),
                        TextEntry::make('city.name')->label('City'),
                        TextEntry::make('department.name')->label('Department'),
                    ])->columns(3),
                Section::make('Emoployee Dates')
                    ->schema([
                        TextEntry::make('date_of_birth')->label('Date of Birth'),
                        TextEntry::make('date_hired')->label('Hired Date'),
                        TextEntry::make('created_at')->label('Created_at'),
                        TextEntry::make('updated_at')->label('Updated At'),
                    ])->columns(4),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
