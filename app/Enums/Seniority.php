<?php

namespace App\Enums;

enum Seniority: string
{
    case Junior = 'jr';
    case Pleno = 'pl';
    case Senior = 'sr';

    public function label(): string
    {
        return match ($this) {
            self::Junior => 'Júnior',
            self::Pleno => 'Pleno',
            self::Senior => 'Sênior',
        };
    }
}
