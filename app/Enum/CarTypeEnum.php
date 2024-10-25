<?php
namespace App\Enum;

enum CarTypeEnum: string

{
    case SEDAN = 'Sedan';
    case HATCHBACK = 'Hatchback';
    case SUV = 'UV';
    case MINIVAN = 'Minivan';
    case CONVERTIBLE = 'Convertible';
    case COUPE = 'Coupe';
    case COUNTRY = 'Country';
}
