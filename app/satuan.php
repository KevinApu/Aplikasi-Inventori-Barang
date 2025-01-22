<?php

namespace App\Enums;

enum satuan: string
{

    case PCS = 'pcs';
    case PACK = 'pack';
    case METER = 'meter';
    case ROLL = 'roll';
    case UNIT = 'unit';
    public static function toArray(): array
    {

        return [
            self::PCS->value,
            self::PACK->value,
            self::METER->value,
            self::ROLL->value,
            self::UNIT->value,
        ];
    }
}
