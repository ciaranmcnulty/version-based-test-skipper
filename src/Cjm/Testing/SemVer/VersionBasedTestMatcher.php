<?php

namespace Cjm\Testing\SemVer;

use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\VersionDetector;

final class VersionBasedTestMatcher implements TestMatcher
{
    /**
     * @var VersionDetector
     */
    private $versionDetector;
    /**
     * @var ConstraintMatcher
     */
    private $constraintMatcher;

    public function __construct(VersionDetector $versionDetector, ConstraintMatcher $constraintMatcher)
    {
        $this->versionDetector = $versionDetector;
        $this->constraintMatcher = $constraintMatcher;
    }

    /**
     * @return bool
     */
    public function matches(Test $test)
    {
        foreach ($test->getConstraints() as $constraint) {
            if (!$this->constraintMatcher->match($constraint, $this->versionDetector->getVersion())) {
                return false;
            }
        }

        return true;
    }
}
