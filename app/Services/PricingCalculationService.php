<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Booking;

class PricingCalculationService
{
    const EXTRA_PERSON_CHARGE = 300.00; // 300 pesos per extra person
    const SENIOR_DISCOUNT_RATE = 0.20; // 20% discount for seniors

    /**
     * Calculate pricing for a booking
     *
     * @param Room $room
     * @param int $numberOfGuests
     * @param int $numberOfSeniors
     * @param int $numberOfPwds
     * @param int $numberOfNights
     * @return array
     */
    public function calculateBookingPricing(Room $room, int $numberOfGuests, int $numberOfSeniors = 0, int $numberOfPwds = 0, int $numberOfNights = 1): array
    {
        // Base room price (per night)
        $baseRoomPrice = $room->price_per_night;
        
        // Calculate total room price for all nights
        $totalRoomPrice = $baseRoomPrice * $numberOfNights;
        
        // Calculate extra person charges
        $extraPersonCharge = 0;
        if ($numberOfGuests > $room->max_guests) {
            $extraPersons = $numberOfGuests - $room->max_guests;
            $extraPersonCharge = $extraPersons * self::EXTRA_PERSON_CHARGE * $numberOfNights;
        }
        
        // Calculate subtotal before discounts
        $subtotal = $totalRoomPrice + $extraPersonCharge;
        
        // Calculate senior discount using new formula: (Total Price ÷ Total Guests) × Number of Seniors × 20%
        $seniorDiscount = 0;
        if ($numberOfSeniors > 0) {
            $pricePerPerson = $subtotal / $numberOfGuests;
            $seniorDiscount = $pricePerPerson * $numberOfSeniors * self::SENIOR_DISCOUNT_RATE;
        }
        
        // Calculate PWD discount using new formula: (Total Price ÷ Total Guests) × Number of PWDs × 20%
        $pwdDiscount = 0;
        if ($numberOfPwds > 0) {
            $pricePerPerson = $subtotal / $numberOfGuests;
            $pwdDiscount = $pricePerPerson * $numberOfPwds * self::SENIOR_DISCOUNT_RATE; // Same rate as seniors
        }
        
        // Calculate total discount (seniors + PWDs)
        $totalDiscount = $seniorDiscount + $pwdDiscount;
        
        // Calculate final total
        $finalTotal = $subtotal - $totalDiscount;
        
        return [
            'base_room_price' => $totalRoomPrice,
            'extra_person_charge' => $extraPersonCharge,
            'senior_discount' => $seniorDiscount,
            'pwd_discount' => $pwdDiscount,
            'total_discount' => $totalDiscount,
            'final_total_price' => max(0, $finalTotal), // Ensure non-negative total
            'breakdown' => [
                'room_price_per_night' => $baseRoomPrice,
                'number_of_nights' => $numberOfNights,
                'total_room_price' => $totalRoomPrice,
                'max_guests' => $room->max_guests,
                'number_of_guests' => $numberOfGuests,
                'extra_persons' => max(0, $numberOfGuests - $room->max_guests),
                'extra_person_rate' => self::EXTRA_PERSON_CHARGE,
                'number_of_seniors' => $numberOfSeniors,
                'number_of_pwds' => $numberOfPwds,
                'senior_discount_rate' => self::SENIOR_DISCOUNT_RATE,
                'pwd_discount_rate' => self::SENIOR_DISCOUNT_RATE, // Same rate as seniors
                'subtotal' => $subtotal,
                'price_per_person' => $numberOfGuests > 0 ? $subtotal / $numberOfGuests : 0,
            ]
        ];
    }

    /**
     * Calculate pricing for an existing booking
     *
     * @param Booking $booking
     * @return array
     */
    public function calculateBookingPricingFromBooking(Booking $booking): array
    {
        if (!$booking->room) {
            throw new \InvalidArgumentException('Booking must have an associated room');
        }

        $numberOfNights = $booking->number_of_nights ?? 1;
        if ($booking->tour_type === 'day_tour') {
            $numberOfNights = 1;
        }

        return $this->calculateBookingPricing(
            $booking->room,
            $booking->number_of_guests,
            $booking->num_senior_citizens ?? 0,
            $booking->num_pwds ?? 0,
            $numberOfNights
        );
    }

    /**
     * Update booking with calculated pricing
     *
     * @param Booking $booking
     * @return Booking
     */
    public function updateBookingPricing(Booking $booking): Booking
    {
        $pricing = $this->calculateBookingPricingFromBooking($booking);
        
        $booking->update([
            'base_room_price' => $pricing['base_room_price'],
            'extra_person_charge' => $pricing['extra_person_charge'],
            'senior_discount' => $pricing['senior_discount'],
            'pwd_discount' => $pricing['pwd_discount'],
            'final_total_price' => $pricing['final_total_price'],
        ]);

        return $booking;
    }

    /**
     * Get pricing breakdown for display
     *
     * @param Booking $booking
     * @return array
     */
    public function getPricingBreakdown(Booking $booking): array
    {
        $pricing = $this->calculateBookingPricingFromBooking($booking);
        
        return [
            'room_price' => $pricing['base_room_price'],
            'extra_person_charge' => $pricing['extra_person_charge'],
            'senior_discount' => $pricing['senior_discount'],
            'final_total' => $pricing['final_total_price'],
            'breakdown' => $pricing['breakdown']
        ];
    }
}
