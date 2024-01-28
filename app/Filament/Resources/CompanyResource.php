<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Company;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

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

                Forms\Components\Section::make('Employment')
                    ->description('Put the Company details in.')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'name')
                            ->native(false)
                            ->label('Country')
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
                            ->label('State')
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
                            ->label('City')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),

                    ])->columns(3),
                //end employment section


                Forms\Components\Select::make('user_id')
                ->nullable()
                ->native(false)
                ->relationship('user', 'name'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('type_of_Business')
                    ->maxLength(45),
                Forms\Components\TextInput::make('size')
                    ->maxLength(45),
                // Forms\Components\TextInput::make('country_id')
                //     ->maxLength(45),
                // Forms\Components\TextInput::make('state_id')
                //     ->maxLength(45),
                // Forms\Components\TextInput::make('city_id')
                //     ->maxLength(45),
                Forms\Components\TextInput::make('phone')
                    ->nullable()
                    ->tel()
                    ->maxLength(45),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(45),
                Forms\Components\TextInput::make('website')
                    ->maxLength(255),
                Forms\Components\TextInput::make('slogan')
                    ->maxLength(256),
                Forms\Components\Textarea::make('about_us')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('mission')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('vision')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_of_Business')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('size')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slogan')
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
