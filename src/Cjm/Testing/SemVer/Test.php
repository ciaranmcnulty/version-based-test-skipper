<?php

namespace Cjm\Testing\SemVer;

final class Test
{
    /**
     * @var Tag[]
     */
    private $tags;

    private function __construct()
    {
    }

    /**
     * @param Tag[]
     *
     * @return Test
     */
    public static function taggedWith(array $tags)
    {
        $scenario = new Test();
        $scenario->tags = $tags;

        return $scenario;
    }

    /**
     * @return Constraint[]
     */
    public function getConstraints()
    {
        $constraints = [];

        foreach ($this->tags as $tag) {
            if ($constraint = $tag->getConstraint()) {
                $constraints[] = $constraint;
            }
        }

        return $constraints;
    }
}
