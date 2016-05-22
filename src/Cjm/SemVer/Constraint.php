<?php

namespace Cjm\SemVer;

final class Constraint
{
    private $string;

    private function __construct()
    {
    }

    public static function fromString($string)
    {
        $constraint = new Constraint();
        $constraint->string = $string;

        return $constraint;
    }

    public function asString()
    {
        return $this->string;
    }

}
