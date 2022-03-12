<?php

namespace App\Auth\Domain;

enum Role: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
