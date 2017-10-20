<?php

namespace AppBundle\Enum;

/**
 * Class RolesEnum
 * @package AppBundle\Enum
 */
class RolesEnum
{
    const ROLE_USER = 'ROLE_USER';
    const SUPER_ADMIN = 'SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ELEMENTS = [
        self::ROLE_USER => self::ROLE_USER,
        self::SUPER_ADMIN => self::SUPER_ADMIN ,
        self::ROLE_ADMIN => self::ROLE_ADMIN,
    ];
}