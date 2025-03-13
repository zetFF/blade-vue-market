<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseUsResource\Pages;
use App\Filament\Resources\WhyChooseUsResource\RelationManagers;
use App\Models\WhyChooseUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WhyChooseUsResource extends Resource
{
    protected static ?string $model = WhyChooseUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('icon')
                            ->options([
                                'truck' => 'Fast Delivery',
                                'shield-check' => 'Secure Payment',
                                'currency-dollar' => 'Best Prices',
                                'star' => 'Quality Food',
                                'users' => 'Expert Team',
                                'phone' => '24/7 Support',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(500),

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('icon')
                    ->searchable(),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListWhyChooseUs::route('/'),
            'create' => Pages\CreateWhyChooseUs::route('/create'),
            'edit' => Pages\EditWhyChooseUs::route('/{record}/edit'),
        ];
    }
}
