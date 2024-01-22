<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
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
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Users';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone_number', 'role'];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Create a new user')
                    ->description('Add a new user to the system.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label("Full Name")
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique()
                            ->label("Email")
                            ->required()
                            ->maxLength(255),
                        // Forms\Components\DateTimePicker::make('email_verified_at'),
                        Select::make('role')
                            ->options([
                                'User' => 'User',
                                'Agent' => 'Agent',
                                'Property Owner' => 'Property Owner',
                                'Admin' => 'Admin',
                            ])
                            ->native(false)
                            ->label('Role')
                            ->searchable(),

                        PhoneInput::make('phone_number')
                            ->label('Phone Number')
                            ->required()
                            ->unique()
                            ->defaultCountry('UG'),

                        // Forms\Components\TextInput::make('otp')
                        //     ->maxLength(255),
                        // Forms\Components\DateTimePicker::make('otp_send_time'),
                        Forms\Components\Toggle::make('is_admin')
                            ->required(),
                        // Forms\Components\Toggle::make('is_user_verified')
                        //     ->required(),
                        // Forms\Components\TextInput::make('password')
                        //     ->password()
                        //     ->required()
                        //     ->maxLength(255),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Email'),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Role'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->label('Phone Number'),
                // Tables\Columns\TextColumn::make('otp')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('otp_send_time')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean(),
                // Tables\Columns\IconColumn::make('is_user_verified')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('lat')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('long')
                // ->searchable(),
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
                Action::make('makeAdmin')
                    ->color('success')
                    ->visible(fn (User $user) => $user->is_admin == 0)
                    ->requiresConfirmation()
                    ->action(function (User $user) {
                        $user->is_admin = 1;
                        $user->save();
                        Notification::make()
                            ->success()
                            ->title('Added Admin')
                            ->body("user $user->name is now an admin")
                            ->send();
                    }),
                Action::make('removeAdmin')
                    ->color('danger')
                    ->visible(fn (User $user) => $user->is_admin == 1)
                    ->requiresConfirmation()
                    ->action(function (User $user) {
                        $user->is_admin = 0;
                        $user->save();
                        Notification::make()
                            ->success()
                            ->title('Added Admin')
                            ->body("user $user->name is now an admin")
                            ->send();
                    }),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
