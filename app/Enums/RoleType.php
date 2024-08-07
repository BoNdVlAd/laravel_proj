<?php

namespace App\Enums;


enum RoleType: int
{
    case ADMIN = 1;
    case CUSTOMER = 2;
    case GUEST = 3;

}
