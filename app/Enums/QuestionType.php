<?php

namespace App\Enums;

class QuestionType extends Enum
{
    const TEXT = 'text';
    const SELECT = 'select';
    const CHECKBOX = 'checkbox';

    const OPTIONS = [
        self::TEXT,
        self::SELECT,
        self::CHECKBOX
    ];
}
