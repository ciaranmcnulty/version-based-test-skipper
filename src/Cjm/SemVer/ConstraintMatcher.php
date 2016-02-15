<?php

namespace Cjm\SemVer;

interface ConstraintMatcher
{
    /**
     * @return boolean
     */
    public function match(Constraint $constraint, Version $version);
}
