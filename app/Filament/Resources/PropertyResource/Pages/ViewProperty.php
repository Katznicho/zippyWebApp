<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Models\Property;
use App\Traits\MessageTrait;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;
use Filament\Actions\Action;
use App\Mail\Payment as ProductMail;
use Filament\Notifications\Notification;
use App\Models\User;
use Throwable;

class ViewProperty extends ViewRecord
{
    use MessageTrait;

    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('View Images')
                ->action(function (Property $record) {
                    return redirect()->route('filament.admin.resources.properties.view-images', $record->id);
                }),
            Action::make('Approve')
                ->visible(fn (Property $record) => !$record->is_approved)
                // ->color('success')
                ->requiresConfirmation()
                ->action(function (Property $record, array $data) {
                    $record->update([
                        'is_approved' => true,
                    ]);
                    $user =  User::find($record->owner_id);
                    $message = "Hello $user->name, your property has been approved successfully.";
                    try {
                        Mail::to($user->email)->send(new ProductMail($user, $message, 'Property approved successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property approved successfully')
                        ->body('The property has been approved successfully')
                        ->send();
                }),

            Action::make('De-Approve')
                ->label('De-Approve')
                ->visible(fn (Property $record) => $record->is_approved)
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (Property $record, array $data) {
                    $record->update([
                        'is_approved' => false,
                    ]);
                    $user =  User::find($record->owner_id);
                    $message = "Hello $user->name, your property has been De-Approved.";
                    try {
                        Mail::to($user->email)->send(new ProductMail($user, $message, 'Property De-Approved successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property De-Approved successfully')
                        ->body('The property has been de-approved successfully')
                        ->send();
                }),

            Action::make("markAsAvailable")
                ->visible(fn (Property $record) => !$record->is_available)
                ->label("Mark as Available")
                ->action(function (Property $record, array $data) {
                    $record->update([
                        'is_available' => true,
                    ]);
                    $user =  User::find($record->owner_id);
                    $message = "Hello $user->name, your property has been marked as Available.";
                    try {
                        Mail::to($user->email)->send(new ProductMail($user, $message, 'Property marked as Available successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property marked as Available successfully')
                        ->body('The property has been marked as Available successfully')
                        ->send();
                }),
            Action::make("markAsNotAvailable")
                ->visible(fn (Property $record) => $record->is_available)
                ->label("Mark as Not Available")
                ->action(function (Property $record, array $data) {
                    $record->update([
                        'is_available' => false,
                    ]);
                    $user =  User::find($record->owner_id);
                    $message = "Hello $user->name, your property has been marked as Not Available.";
                    try {
                        Mail::to($user->email)->send(new ProductMail($user, $message, 'Property marked as Not Available successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property marked as Not Available successfully')
                        ->body('The property has been marked as Not Available successfully')
                        ->send();
                })


        ];
    }
}
