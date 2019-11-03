<?php
declare(strict_types=1);

namespace App\Service\CriteriaTypes;


class Factory
{
    public static function create($name): CriteriaTypeInterface
    {
        if ($name == 'InArray') {
            return new InArray();
        } elseif ($name == 'Time') {
            return new Time();
        }
    }
}
