<?php

declare(strict_types=1);

namespace App\Infrastructure\Resources;

/**
 * @package Infrastructure
 */
trait WithDataFormatters
{
    private function formatDate($date)
    {
        if (is_string($date)) {
            $date = strtotime($date);
            return date('Y-m-d H:i:s', $date);
        }

        return date_format($date, 'Y-m-d H:i:s');
    }
}
