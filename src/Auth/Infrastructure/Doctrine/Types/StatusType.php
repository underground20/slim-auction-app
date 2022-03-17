<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Doctrine\Types;

use App\Auth\Domain\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use JetBrains\PhpStorm\Pure;

class StatusType extends IntegerType
{
    public const NAME = 'auth_user_status';

    #[Pure] public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Status ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (!empty($value)) ? Status::from($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
