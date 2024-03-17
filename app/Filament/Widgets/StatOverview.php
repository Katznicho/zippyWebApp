<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyNotification;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total number of customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 9])
                ->url(route('filament.admin.resources.users.index'))
                ->extraAttributes([
                    'class' => 'text-white text-lg cursor-pointer',
                ]),
            Stat::make('Total Transactions', Payment::count())
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total number of transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 9])
                ->url(route('filament.admin.resources.payments.index'))
                ->extraAttributes([
                    'class' => 'text-white text-lg cursor-pointer',
                ]),
            Stat::make('Total Properties', Property::count())
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total number of users')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 9])
                ->url(route('filament.admin.resources.properties.index'))
                ->extraAttributes([
                    'class' => 'text-white text-lg cursor-pointer',
                ]),
            Stat::make('Total Categories', Category::count())
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total number of branches')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 9])
                ->url(route('filament.admin.resources.categories.index'))
                ->extraAttributes([
                    'class' => 'text-white text-lg cursor-pointer',
                ]),
            Stat::make('Total Bookings', Booking::count())
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total number of cards')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                // ->chart([7, 2, 10, 3, 15, 4, 9])
                ->url(route('filament.admin.resources.bookings.index'))
                ->extraAttributes([
                    'class' => 'text-white text-lg cursor-pointer',
                ]),
            // Stat::make('Total Property Notifications', PropertyNotification::count())
            //     ->icon('heroicon-o-arrow-trending-up')
            //     ->description('Total number of cards')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up')
            //     ->color('success')
            //     // ->chart([7, 2, 10, 3, 15, 4, 9])
            //     // ->url(route('filament.admin.resources.deliveries.index'))
            //     ->extraAttributes([
            //         'class' => 'text-white text-lg cursor-pointer',
            //     ]),
        ];
    }
}
