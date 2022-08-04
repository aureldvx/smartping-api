<?php

declare(strict_types=1);

namespace SmartpingApi\Helper;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;

class DateTimeHelpers
{
    public static function createMutable(?string $datetime = null, string $format = null): DateTimeInterface
    {
        try {
            if ($datetime && $format) {
                $newDatetime = DateTime::createFromFormat('Y-m-d', $datetime, new DateTimeZone('Europe/Paris'));
                if (!$newDatetime) {
                    throw new Exception();
                }

                return $newDatetime;
            }

            return new DateTime($datetime ?? 'now', new DateTimeZone('Europe/Paris'));
        } catch (Exception) {
            return new DateTime('now');
        }
    }

    public static function createImmutable(?string $datetime = null, string $format = null): DateTimeImmutable
    {
        try {
            if ($datetime && $format) {
                $datetimeImmutable = DateTimeImmutable::createFromFormat('Y-m-d', $datetime, new DateTimeZone('Europe/Paris'));
                if (!$datetimeImmutable) {
                    throw new Exception();
                }

                return $datetimeImmutable;
            }

            return new DateTimeImmutable($datetime ?? 'now', new DateTimeZone('Europe/Paris'));
        } catch (Exception) {
            return new DateTimeImmutable('now');
        }
    }
}
