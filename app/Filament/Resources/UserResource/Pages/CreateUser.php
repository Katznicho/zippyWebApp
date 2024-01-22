<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\AccountCreation;
use App\Traits\MessageTrait;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CreateUser extends CreateRecord
{
    use MessageTrait;
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User registered successfully')
            ->body('The user has been registered successfully');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $name = $data['name'];
        $email = $data['email'];
        $password = Str::random(8);
        $role = $data['role'];
        $phone_number = $data['phone_number'];
        $data['password'] = Hash::make($password);
        try {
            // Send the OTP code to the user's email
            Mail::to($email)->send(new AccountCreation($name, $password,  $role));
        } catch (\Throwable $th) {
            // throw $th;
            dd($th);
        }

        $message = "Hello $name, your account with  Zippy  as a $role has been created. Please use the following : $password  as your one time password to login in the app 
        If you dont have the app please contact us or download the app from the play store
        <a href='https://play.google.com/store/apps/details?id=com.otp.otp'>https://play.google.com/store/apps/details?id=com.otp.otp</a>";

         $this->sendMessage($phone_number, $message);

        return $data;
    }
}
