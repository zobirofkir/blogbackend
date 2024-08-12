<?php
namespace App\Enums;

enum RolesEnum : string 
{
    case GUEST = "guest";
    case ADMIN = "admin";

    public function label() : string {
        return match ($this)
        {
            static::GUEST => "Guest",
            static::ADMIN => "Admin"
        };
    }
}