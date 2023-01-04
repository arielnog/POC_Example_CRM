<?php

namespace App\Enum;

final class StageList
{
    const LEAD = "lead";
    const OPPORTUNITY = "opportunity";
    const CUSTOMER = "customer";

    public static function validValues(): array
    {
        return [
            self::LEAD,
            self::OPPORTUNITY,
            self::CUSTOMER,
        ];
    }
}
