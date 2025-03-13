<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialOfferResource\Pages;
use App\Filament\Resources\SpecialOfferResource\RelationManagers;
use App\Models\SpecialOffer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialOfferResource extends Resource
{
    protected static ?string $model = SpecialOffer::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Vendor Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Offer Details')
                            ->schema([
                                Forms\Components\Select::make('vendor_id')
                                    ->relationship('vendor', 'business_name')
                                    ->searchable()
                                    ->required(),

                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('discount_type')
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->required()
                                    ->live(),

                                Forms\Components\TextInput::make('discount_value')
                                    ->required()
                                    ->numeric()
                                    ->prefix(fn (Forms\Get $get) => 
                                        $get('discount_type') === 'percentage' ? '%' : 'Rp')
                                    ->minValue(fn (Forms\Get $get) => 
                                        $get('discount_type') === 'percentage' ? 1 : 1000)
                                    ->maxValue(fn (Forms\Get $get) => 
                                        $get('discount_type') === 'percentage' ? 100 : null),

                                Forms\Components\TextInput::make('minimum_order')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->default(0),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Validity Period')
                            ->schema([
                                Forms\Components\DateTimePicker::make('start_date')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('end_date')
                                    ->required()
                                    ->after('start_date'),

                                Forms\Components\Toggle::make('status')
                                    ->label('Active')
                                    ->default(true),
                            ])
                            ->columns(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.business_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('discount_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('discount_value')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->discount_type === 'percentage' 
                            ? "{$state}%" 
                            : "Rp " . number_format($state, 0, ',', '.');
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('minimum_order')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vendor')
                    ->relationship('vendor', 'business_name'),

                Tables\Filters\SelectFilter::make('discount_type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ]),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Active Status'),

                Tables\Filters\Filter::make('active_period')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn ($query) => $query->whereDate('start_date', '>=', $data['from'])
                            )
                            ->when(
                                $data['until'],
                                fn ($query) => $query->whereDate('end_date', '<=', $data['until'])
                            );
                    }),
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
            'index' => Pages\ListSpecialOffers::route('/'),
            'create' => Pages\CreateSpecialOffer::route('/create'),
            'edit' => Pages\EditSpecialOffer::route('/{record}/edit'),
        ];
    }
}
