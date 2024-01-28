<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatesRelationManager extends RelationManager
{
    protected static string $relationship = 'states';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    // ->options([
                    //     'active'=>'active',
                    //     'inactive'=>'inactive',
                    // ])
                    ->relationship(name: 'country', titleAttribute: 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ->required(),


                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('country.name')
                //     ->searchable(isIndividual: true)
                //     ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->label('State name')
                    ->hidden(!auth()->user()->email === 'admin@admin.com'),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
