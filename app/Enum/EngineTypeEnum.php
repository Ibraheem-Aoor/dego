<?php
namespace App\Enum;

enum EngineTypeEnum: string
{
    case PETROL = 'Petrol';
    case DIESEL = 'Diesel';

    case HYBRID = 'Hybrid';
    case ELECTRIC = 'Electric';
}
