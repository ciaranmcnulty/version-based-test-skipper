<?php

namespace Cjm\Composer;

use Cjm\SemVer\Constraint;
use Cjm\SemVer\Version;
use Composer\Semver\Semver;

class ConstraintMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Cjm\SemVer\ConstraintMatcher
     */
    private $constraintMatcher;

    public function setUp()
    {
        $this->constraintMatcher = new ConstraintMatcher(new Semver());
    }

    public function testItIsAConstraintMatcher()
    {
        $this->assertInstanceOf('Cjm\SemVer\ConstraintMatcher', $this->constraintMatcher);
    }

    public function testItMatchesASimpleCase()
    {
        $result = $this->constraintMatcher->match(
            Constraint::fromString('~3.0'), Version::fromString('3.1')
        );

        $this->assertTrue($result);
    }

    public function testItDoesNotMatchASimpleCase()
    {
        $result = $this->constraintMatcher->match(
            Constraint::fromString('~3.0'), Version::fromString('2.1')
        );

        $this->assertFalse($result);
    }
}