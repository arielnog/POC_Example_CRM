<?php

namespace App\Enum;

final class StatusList
{
    const OPEN = "open";
    const IN_PROGRESS = "in_progress";
    const DROPPED = "dropped";

    public static function validValues(): array
    {
        return [
            self::OPEN,
            self::IN_PROGRESS,
            self::DROPPED
        ];
    }
}
