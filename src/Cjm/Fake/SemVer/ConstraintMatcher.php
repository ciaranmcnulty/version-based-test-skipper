<?php

namespace Cjm\Fake\SemVer;

use Cjm\SemVer\Constraint;
use Cjm\SemVer\ConstraintMatcher as ConstraintMatcherInterface;
use Cjm\SemVer\Version;

final class ConstraintMatcher implements ConstraintMatcherInterface
{
    /**
     * @return boolean
     */
    public function match(Constraint $constraint, Version $version)
    {
        return (boolean) 0 !== strpos($constraint->asString(), '~' . (int)$version->asString(0));
    }
}