<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatingHourResource\Pages;
use App\Filament\Resources\OperatingHourResource\RelationManagers;
use App\Models\OperatingHour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OperatingHourResource extends Resource
{
    protected static ?string $model = OperatingHour::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Vendor Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('vendor_id')
                            ->relationship('vendor', 'business_name')
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('day')
                            ->options([
                                'monday' => 'Monday',
                                'tuesday' => 'Tuesday',
                                'wednesday' => 'Wednesday',
                                'thursday' => 'Thursday',
                                'friday' => 'Friday',
                                'saturday' => 'Saturday',
                                'sunday' => 'Sunday',
                            ])
                            ->required(),

                        Forms\Components\TimePicker::make('open_time')
                            ->required()
                            ->seconds(false),

                        Forms\Components\TimePicker::make('close_time')
                            ->required()
                            ->seconds(false)
                            ->after('open_time'),

                        Forms\Components\Toggle::make('is_closed')
                            ->label('Closed on this day?')
                            ->default(false)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('open_time', null);
                                    $set('close_time', null);
                                }
                            }),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.business_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('day')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('open_time')
                    ->time()
                    ->sortable(),

                Tables\Columns\TextColumn::make('close_time')
                    ->time()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_closed')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vendor')
                    ->relationship('vendor', 'business_name'),

                Tables\Filters\SelectFilter::make('day')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ]),

                Tables\Filters\TernaryFilter::make('is_closed')
                    ->label('Closed Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('day', 'asc');
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
            'index' => Pages\ListOperatingHours::route('/'),
            'create' => Pages\CreateOperatingHour::route('/create'),
            'edit' => Pages\EditOperatingHour::route('/{record}/edit'),
        ];
    }
}
