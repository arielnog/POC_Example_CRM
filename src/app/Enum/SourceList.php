<?php

namespace App\Enum;

final class SourceList
{
    const FACEBOOK = "facebook";
    const WHATSAPP = "whatsapp";
    const GOOGLE = "google";
    const WEBSITE = "website";

    public static function validValues(): array
    {
        return [
            self::FACEBOOK,
            self::WHATSAPP,
            self::GOOGLE,
            self::WEBSITE
        ];
    }
}
