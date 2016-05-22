<?php

namespace Cjm\Composer;

use Cjm\SemVer\Constraint;
use Cjm\SemVer\ConstraintMatcher as ConstraintMatcherInterface;
use Cjm\SemVer\Version;
use Composer\Semver\Comparator;
use Composer\Semver\Semver;

class ConstraintMatcher implements ConstraintMatcherInterface
{
    /**
     * @var Semver
     */
    private $semVer;

    public function __construct(Semver $semVer)
    {
        $this->semVer = $semVer;
    }

    /**
     * @return boolean
     */
    public function match(Constraint $constraint, Version $version)
    {
        return $this->semVer->satisfies($version->asString(), $constraint->asString());
    }
}