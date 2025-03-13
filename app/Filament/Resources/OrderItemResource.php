<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Filament\Resources\OrderItemResource\RelationManagers;
use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'order_number')
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
                                        $set('unit_price', $product->price);
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $old, Forms\Set $set, $get) {
                                $unitPrice = $get('unit_price') ?? 0;
                                $set('subtotal', $state * $unitPrice);
                            }),

                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $old, Forms\Set $set, $get) {
                                $quantity = $get('quantity') ?? 1;
                                $set('subtotal', $state * $quantity);
                            }),

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order')
                    ->relationship('order', 'order_number'),

                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
