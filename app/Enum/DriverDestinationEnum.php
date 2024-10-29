<?php
namespace App\Enum;

enum DriverDestinationEnum: string
{
    case FROM_AIRPORT = 'from_airport';
    case TO_AIRPORT = 'to_airport';
    case BETWEEN_CITIES = 'between_cities';


}
