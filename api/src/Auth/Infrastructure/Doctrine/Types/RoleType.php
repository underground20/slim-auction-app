<?php

namespace App\Auth\Infrastructure\Doctrine\Types;

use App\Auth\Domain\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use JetBrains\PhpStorm\Pure;

class RoleType extends StringType
{
    public const NAME = 'auth_user_role';

    #[Pure] public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Role ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Role
    {
        return (!empty($value)) ? Role::from($value): null;
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
