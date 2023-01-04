<?php

namespace App\Enum;

final class PipelineList
{
    const CONTACTED = "contacted";
    const LOST = "lost";
    const WON = "won";
    const PROPOSAL_SENT = "proposal_sent";
    const NEGOTIATION = "negotiation";
    const MEETING_BOOKED = "meeting_booked";

    public static function validValues(): array
    {
        return [
            self::CONTACTED,
            self::LOST,
            self::WON,
            self::PROPOSAL_SENT,
            self::NEGOTIATION,
            self::MEETING_BOOKED
        ];
    }

    public static function validStageValues()
    {
        return [
            self::CONTACTED,
            self::LOST,
            self::WON,
            self::PROPOSAL_SENT,
            self::NEGOTIATION,
            self::MEETING_BOOKED
        ];
    }
}
