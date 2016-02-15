<?php

namespace Cjm\Testing\SemVer;

use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\VersionDetector;

final class TestMatcher
{
    /**
     * @var VersionDetector
     */
    private $phpVersionDetector;
    /**
     * @var ConstraintMatcher
     */
    private $constraintMatcher;

    public function __construct(VersionDetector $phpVersionDetector, ConstraintMatcher $constraintMatcher)
    {
        $this->phpVersionDetector = $phpVersionDetector;
        $this->constraintMatcher = $constraintMatcher;
    }

    /**
     * @return bool
     */
    public function matches(Test $scenario)
    {
        foreach ($scenario->getConstraints() as $constraint) {
            if (!$this->constraintMatcher->match($constraint, $this->phpVersionDetector->getVersion())) {
                return false;
            }
        }

        return true;
    }
}
