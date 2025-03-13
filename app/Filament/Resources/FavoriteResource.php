<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FavoriteResource\Pages;
use App\Filament\Resources\FavoriteResource\RelationManagers;
use App\Models\Favorite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FavoriteResource extends Resource
{
    protected static ?string $model = Favorite::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Customer Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->required()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $product = \App\Models\Product::find($state);
                                    if ($product) {
                                        $set('vendor_name', $product->vendor->business_name);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('vendor_name')
                            ->label('Vendor')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.vendor.business_name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('product.is_available')
                    ->label('Available')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),

                Tables\Filters\SelectFilter::make('vendor')
                    ->relationship('product.vendor', 'business_name'),

                Tables\Filters\TernaryFilter::make('product_availability')
                    ->label('Product Availability')
                    ->queries(
                        true: fn ($query) => $query->whereHas('product', fn ($q) => $q->where('is_available', true)),
                        false: fn ($query) => $query->whereHas('product', fn ($q) => $q->where('is_available', false)),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
