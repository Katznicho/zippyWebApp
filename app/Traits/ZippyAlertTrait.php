<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyNotification;
use App\Models\User;
use Illuminate\Http\Request;

trait ZippyAlertTrait
{

    /**
     * @var float The cost percentage
     */
    protected $costPercentage = 0.3;

    /**
     * @var float The location percentage
     */
    protected $locationPercentage = 0.3;

    /**
     * @var float The service percentage
     */
    protected $servicesPercentage = 0.1;

    /**
     *@var float The amenities percentage 
     */
    protected $amenitiesPercentage = 0.1;

    /**
     * @var float $rooms The number of rooms
     */

    protected $roomsPercentage = 0.15;

    /**
     * @var float $bathrooms The number of bathrooms
     */

    protected $bathroomsPercentage = 0.05;

    /**
     *@var float $threshold The threshold
     */

    protected $threshold = 0.7;

    public function zippySearchAlgorithm(Request $request, User $user)
    {

        try {
            $category_id = $request->category_id;

            $cost = $request->cost;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $services = $request->services;
            $amenities = $request->amenities;
            $rooms = $request->rooms;
            $bathrooms = $request->bathrooms;


            $threshold = 0.7; // Adjust the threshold as needed

            $properties =  Property::where('category_id', $category_id)->get();
            // Loop through each chunk of properties
            foreach ($properties as $property) {


                // Calculate the score for each property
                $score = 0.0;
                // Calculate score for cost
                $costPercentage = $this->calculateCost(intval($property->price),  intval($cost));
                return $costPercentage;
                $score += $costPercentage;

                // Calculate score for distance
                $distancePercentage =  $this->calculateDistance($property->lat, $property->long, $latitude, $longitude);

                $score += $distancePercentage;

                $roomPecentage =  $this->calculateRoomPercentage($property->rooms, $rooms);
                $score += $roomPecentage;

                $bathroomsPercentage = $this->calculateBathroomPercentage($property->bathrooms, $bathrooms);
                $score += $bathroomsPercentage;
                $servicesPercentage = $this->calculateServicesPercentage($property->getServicesIdsAttribute(), $services);
                $score += $servicesPercentage;
                $amenitiesPercentage = $this->calculateAmenitiesPercentage($property->getAmenitiesIdsAttribute(), $amenities);
                $score += $amenitiesPercentage;

                // return $score;

                // Check if the overall score exceeds the threshold
                if ($score >= 0.7) {

                    // Send message to the user
                    $notiification = Notification::create([
                        'user_id' => $user->id,
                        'property_id' => $property->id,
                        'title' => "Property Zippy Alert",
                        'message' => "Hello " . $user->name . ",\n\n" . "Your Zippy Alert has been triggered.\n\n" . "Regards,\n" . "Zippy Team",
                    ]);
                    //create a property notification
                    PropertyNotification::create([
                        'property_id' => $property->id,
                        'user_id' => $user->id,
                        'score' => $score,
                        'match_percentage' => $score,
                        'notification_id' => $notiification->id,
                        'is_enabled' => true,
                        'cost_percentage' => $costPercentage,
                        'location_percentage' => $distancePercentage,
                        'services_percentage' => $servicesPercentage,
                        'amenities_percentage' => $amenitiesPercentage,
                        'rooms_percentage' => $roomPecentage,
                        'bathrooms_percentage' => $bathroomsPercentage

                    ]);
                    return true;
                } else {
                    return false;
                }
            }


            // Additional code after processing properties...
        } catch (\Throwable $th) {
            // Handle exceptions if needed
            return $th->getMessage();
        }
    }

    // Helper method to calculate distance between two points (latitude and longitude)
    private function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        // Calculate the distance between two points using Haversine formula
        $earthRadius = 6371; // Radius of the Earth in kilometers
        $deltaLatitude = deg2rad($latitude2 - $latitude1);
        $deltaLongitude = deg2rad($longitude2 - $longitude1);
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Distance in kilometers

        // Assign matching percentage based on distance ranges
        if ($distance >= 1 && $distance < 2 || $distance == 0) {
            return 0.3;
        } elseif ($distance >= 2 && $distance < 5) {
            return 0.2;
        } elseif ($distance >= 5 && $distance < 10) {
            return 0.1;
        } else {
            return 0;
        }
    }


    // Helper method to calculate match percentage between two arrays (e.g., services, amenities)
    private function calculateMatchPercentage($array1, $array2)
    {
        // Calculation logic for match percentage
    }

    // Helper method to send messages


    private function calculateCost($propertyCost, $userEstimatedCost)
    {
        $diff =  $propertyCost - $userEstimatedCost;
        if ($diff <= 0) {
            return 0.3;
        } else {
            //get 50% of the estimated cost
            $half_estimated_cost = $diff / 2;

            $new_estimate =  $diff / $half_estimated_cost;
            if ($new_estimate > 0.5) {
                return 0.0;
            } else if ($new_estimate >= 0.4 && $new_estimate < 0.5) {
                return 0.1;
            } else if ($new_estimate >= 0.3 && $new_estimate < 0.4) {
                return 0.2;
            } else if ($new_estimate >= 0.1 && $new_estimate <= 0.2) {
                return 0.3;
            } else {
                return $new_estimate;
            }
        }
    }

    private function calculateRoomPercentage($propertyRooms, $userRooms)
    {
        // Calculate the percentage difference between property rooms and user preference
        $roomDifference = abs($propertyRooms - $userRooms);

        // Assign matching percentage based on the difference, ensuring the maximum percentage is 0.15
        if ($roomDifference == 0) {
            return 0.15; // Exact match, maximum percentage
        } elseif ($roomDifference == 1) {
            return 0.1; // One room difference
        } elseif ($roomDifference == 2) {
            return 0.05; // Two rooms difference
        } else {
            return 0; // No match
        }
    }

    private function calculateBathroomPercentage($propertyBathrooms, $userBathrooms)
    {
        // Calculate the percentage difference between property bathrooms and user preference
        $bathroomDifference = abs($propertyBathrooms - $userBathrooms);

        // Assign matching percentage based on the difference, ensuring the maximum percentage is 0.05
        if ($bathroomDifference == 0) {
            return 0.05; // Exact match, maximum percentage
        } elseif ($bathroomDifference == 1) {
            return 0.03; // One bathroom difference
        } elseif ($bathroomDifference == 2) {
            return 0.02; // Two bathrooms difference
        } else {
            return 0; // No match
        }
    }

    private function calculateAmenitiesPercentage($propertyAmenities, $userAmenities)
    {
        // Check if the user amenities array is empty
        if (empty($userAmenities)) {
            return 0.1; // Perfect match, maximum percentage
        }

        // Check if all amenity IDs in userAmenities exist in propertyAmenities
        $commonAmenities = array_intersect($propertyAmenities, $userAmenities);

        // Calculate the percentage of common amenities
        $percentage = count($commonAmenities) / count($userAmenities);

        // Assign matching percentage based on the percentage of common amenities
        if ($percentage == 1) {
            return 0.1; // All user amenities exist in property amenities, maximum percentage
        } elseif ($percentage >= 0.8) {
            return 0.08; // 80% or more of user amenities exist in property amenities
        } elseif ($percentage >= 0.5) {
            return 0.05; // 50% or more of user amenities exist in property amenities
        } else {
            return 0; // No match
        }
    }

    private function calculateServicesPercentage($propertyServices, $userServices)
    {
        // Check if the user services array is empty
        if (empty($userServices)) {
            return 0.1; // Perfect match, maximum percentage
        }

        // Check if all service IDs in userServices exist in propertyServices
        $commonServices = array_intersect($propertyServices, $userServices);

        // Calculate the percentage of common services
        $percentage = count($commonServices) / count($userServices);

        // Assign matching percentage based on the percentage of common services
        if ($percentage == 1) {
            return 0.1; // All user services exist in property services, maximum percentage
        } elseif ($percentage >= 0.8) {
            return 0.08; // 80% or more of user services exist in property services
        } elseif ($percentage >= 0.5) {
            return 0.05; // 50% or more of user services exist in property services
        } else {
            return 0; // No match
        }
    }
}
