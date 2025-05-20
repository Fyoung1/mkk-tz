<?php

namespace app\Enums;

enum Status : string
{
    case Active = 'active';
    case Done = 'done';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Активна',
            self::Done => 'Выполнено',
        };
    }
}
