<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Amenity;
use App\Models\Property;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Property';

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'category.name', 'owner.name', 'agent.name', 'description', 'name', 'is_available', 'is_approved', 'number_of_beds',
            'number_of_baths', 'number_of_rooms', 'price',
            'location',
            'zippy_id',
        ];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Create a new property')
                    ->description('Add a new property to the system.')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', "name")
                            ->required()
                            ->label("Property Category"),
                        Forms\Components\Select::make('owner_id')
                            ->relationship('owner', "name")
                            ->required()
                            ->label("Owner"),
                        Forms\Components\Select::make('agent_id')
                            ->relationship('agent', "name")
                            ->required()
                            ->label("Agent"),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->maxLength(255),

                        Repeater::make('public_facilities')
                            ->schema([
                                Forms\Components\TextInput::make('public_facilities')
                                    ->required()
                            ])
                            ->addActionLabel('Add Facility')
                            ->collapsible()
                            ->label("Add Public Facilities"),

                        Repeater::make('amenityProperties')
                            ->relationship('amenityProperties')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make("amenity_id")
                                    ->required()
                                    ->label("Amenities")
                                    ->options(Amenity::all()->pluck("name", "id"))
                                    ->searchable()

                            ]),

                        Repeater::make('propertyServices')
                            ->relationship('propertyServices')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make("service_id")
                                    ->required()
                                    ->label("Services")
                                    ->options(Amenity::all()->pluck("name", "id"))
                                    ->searchable()

                            ])
                            ,


                        Forms\Components\Toggle::make('is_available')
                            ->required(),
                        Forms\Components\Toggle::make('is_approved')
                            ->required(),
                        Forms\Components\TextInput::make('number_of_beds')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('number_of_baths')
                            ->required()
                            ->numeric()
                            ->default(0),


                        Forms\Components\TextInput::make('furnishing_status')
                            ->maxLength(255),
                        Forms\Components\Select::make('status_id')
                            ->relationship('status', "name")
                            ->label("Property Status")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('payment_period_id')
                            ->relationship('paymentPeriod', "name")
                            ->label("Payment Period")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zippy_id')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('currency_id')
                            ->relationship('currency', "name")
                            ->label("Currency")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('property_size')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('year_built')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('lat')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('long')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255),

                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label("Cover Image")
                    ->circular(),
                Tables\Columns\TextColumn::make('zippy_id')
                    ->searchable()
                    ->label('Zippy Id')
                    ->copyable()
                    ->toggleable()
                    ->label('Zippy Id'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Category'),
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Owner'),
                Tables\Columns\TextColumn::make('agent.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Agent'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('images')
                //     ->searchable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('number_of_beds')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_baths')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('furnishing_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency.name')
                    ->searchable()
                    ->label('Currency')
                    ->toggleable()
                    ->copyable()
                    ->label('Currency'),
                Tables\Columns\TextColumn::make('status.name')
                    ->searchable()
                    ->label('Property Status')
                    ->toggleable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('paymentPeriod.name')
                    ->searchable()
                    ->label('Payment Period')
                    ->toggleable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('property_size')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Property Size'),
                Tables\Columns\TextColumn::make('year_built')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Year Built'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Location'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
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
                // Tables\Filters\TrashedFilter::make(),
                Filter::make('is_available')
                    ->toggle()
                    ->label('Available Properties')
                    ->query(fn (Builder $query): Builder => $query->where('is_available', true)),
                Filter::make('is_approved')
                    ->toggle()
                    ->label('Approved Properties')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', true)),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                                ->removeField('from');
                        }

                        if ($data['until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                                ->removeField('until');
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            // RelationManagers::
            // RelationManagers\AmenitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
            'view-images' => Pages\ViewImages::route('/{record}/view-images'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
