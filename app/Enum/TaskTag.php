<?php

namespace App\Enums;

enum TaskTag: string
{
    case BUG = 'bug';
    case FEATURE = 'feature';
    case ENHANCEMENT = 'enhancement';
    case CHANGE_REQUEST = 'change_request';
    case URGENT = 'urgent';
    case DOCUMENTATION = 'documentation';
    case DESIGN = 'design';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
