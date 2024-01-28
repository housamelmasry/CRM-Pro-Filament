<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Store';


    protected static ?int $navigationSort = 2;

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
                Forms\Components\TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(45),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->native(false)
                    ->preload()
                    // ->multiple()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            // ->hiddenLabel()
                            ->placeholder('Category Name')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Description')
                            ->maxLength(255),
                    ]),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('available_qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('brand')
                    ->required()
                    ->maxLength(45),
                Forms\Components\DateTimePicker::make('last_order_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('date_added')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('user.name')
                //     // ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('available_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->words(2),
                Tables\Columns\TextColumn::make('last_order_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_added')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
