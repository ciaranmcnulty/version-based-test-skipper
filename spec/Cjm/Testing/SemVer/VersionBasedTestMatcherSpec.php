<?php

namespace spec\Cjm\Testing\SemVer;

use Cjm\SemVer\Constraint;
use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector;
use Cjm\Testing\SemVer\Tag;
use Cjm\Testing\SemVer\Test;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VersionBasedTestMatcherSpec extends ObjectBehavior
{
    public function let(VersionDetector $versionProvider, ConstraintMatcher $constraintMatcher)
    {
        $this->beConstructedWith($versionProvider, $constraintMatcher);
    }

    function it_matches_a_scenario_tagged_with_compatible_constraints(VersionDetector $versionProvider, ConstraintMatcher $constraintMatcher)
    {
        $versionProvider->getVersion()->willReturn(Version::fromString('5.7.1'));
        $constraintMatcher->match(Constraint::fromString('~5.6'), Version::fromString('5.7.1'))->willReturn(true);

        $this->matches(Test::taggedWith(array(Tag::fromString('php:~5.6'))))->shouldReturn(true);
    }

    function it_doesn_not_match_a_scenario_tagged_with_incompatible_constraints(VersionDetector $versionProvider, ConstraintMatcher $constraintMatcher)
    {
        $versionProvider->getVersion()->willReturn(Version::fromString('5.7.1'));
        $constraintMatcher->match(Constraint::fromString('~7.0'), Version::fromString('5.7.1'))->willReturn(false);

        $this->matches(Test::taggedWith(array(Tag::fromString('php:~7.0'))))->shouldReturn(false);
    }
}
