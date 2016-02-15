<?php

namespace Cjm\Testing\SemVer;

use Cjm\SemVer\Constraint;

final class Tag
{
    private $string;

    private function __construct()
    {
    }

    /**
     * @return Tag
     */
    public static function fromString($string)
    {
        $tag = new Tag();
        $tag->string = $string;

        return $tag;
    }

    /**
     * @return Constraint|null
     */
    public function getConstraint()
    {
        if (preg_match('/^php:(?<constraint>.*)$/', $this->string, $matches)){
            return Constraint::fromString($matches['constraint']);
        }
    }
}
