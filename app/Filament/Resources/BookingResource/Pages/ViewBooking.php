<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Mail;
use App\Mail\Payment as BookingMail;
use Filament\Notifications\Notification;
use Throwable;
use App\Models\Notification as NotificationModel;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('De-Approve')
                ->label('De-Approve')
                ->visible(fn (Booking $record) => $record->status == "Approved")
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (Booking $record, array $data) {
                    $record->update([
                        'status' => "Failed",
                    ]);
                    $user =  User::find($record->user_id);
                    $message = "Hello $user->name, your booking has been DE-Approved.";
                    try {
                        NotificationModel::create([
                            'user_id' => $user->id,
                            'property_id' => $record->property_id,
                            'title' => "Property Booking De-Approved",
                            'message' => "Hello " . $user->name . ",\n\n" . "Your Booking of " . $record->property->name . " has been De-Approved.\n\n" . "Regards,\n" . "Zippy Team",
                        ]);

                        Mail::to($user->email)->send(new BookingMail($user, $message, 'Property  Booking De-Approved successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property  Booking  has De-Approved successfully')
                        ->body('The property booking has been  de-approved successfully')
                        ->send();
                }),

            Action::make('Approve')
                ->label('Approve')
                ->visible(fn (Booking $record) => $record->status == "Pending")
                ->color('success')
                ->requiresConfirmation()
                ->action(function (Booking $record, array $data) {
                    $record->update([
                        'status' => "Approved",
                    ]);
                    $user =  User::find($record->user_id);
                    $message = "Hello $user->name, your booking has been Approved.";
                    try {
                        NotificationModel::create([
                            'user_id' => $user->id,
                            'property_id' => $record->property_id,
                            'title' => "Property Booking Approved",
                            'message' => "Hello " . $user->name . ",\n\n" . "Your Booking of " . $record->property->name . " has been Approved.\n\n" . "Regards,\n" . "Zippy Team",
                        ]);

                        Mail::to($user->email)->send(new BookingMail($user, $message, 'Property  Booking Approved successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property  Booking  has Approved successfully')
                        ->body('The property booking has been  approved successfully')
                        ->send();
                }),

            Action::make("markAsAvailable")
                ->visible(fn (Booking $record) => !$record->is_available)
                ->label("Mark as Available")
                ->action(function (Booking $record, array $data) {
                    $record->update([
                        'is_available' => true,
                    ]);
                    $user =  User::find($record->owner_id);
                    $message = "Hello $user->name, your property has been marked as Available.";
                    try {
                        Mail::to($user->email)->send(new BookingMail($user, $message, 'Property marked as Available successfully'));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property marked as Available successfully')
                        ->body('The property has been marked as Available successfully')
                        ->send();
                }),
            Action::make("markAsNotAvailable")
                ->visible(fn (Booking $record) => $record->is_available)
                ->label("Mark as Not Available")
                ->action(function (Booking $record, array $data) {
                    $record->update([
                        'status' => "Failed",
                    ]);
                    $user =  User::find($record->user_id);
                    $message = "Hello $user->name, your booking of " . $record->property->name . " is not available.";
                    try {
                        NotificationModel::create([
                            'user_id' => $user->id,
                            'property_id' => $record->property_id,
                            'title' => "Booked Property Update",
                            'message' => "Hello " . $user->name . ",\n\n" . "Your Booking of " . $record->property->name . " is not available.\n\n" . "Regards,\n" . "Zippy Team",
                        ]);

                        Mail::to($user->email)->send(new BookingMail($user, $message, 'Property Not Available '));
                    } catch (Throwable $th) {
                    }
                    Notification::make()
                        ->success()
                        ->title('Property  Booking  has Approved successfully')
                        ->body('The property booking has been  approved successfully')
                        ->send();
                    Notification::make()
                        ->success()
                        ->title('Property marked as Not Available successfully')
                        ->body('The property has been marked as Not Available successfully')
                        ->send();
                })
        ];
    }
}
