<?php

namespace spec\Cjm\Testing\SemVer;

use Cjm\SemVer\Constraint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class TagSpec extends ObjectBehavior
{
    function it_returns_a_constraint_when_it_is_a_php_tag()
    {
        $this->beConstructedFromString("php:~5.6");

        $this->getConstraint()->shouldBeLike(Constraint::fromString('~5.6'));
    }

    function it_does_not_return_a_constraint_when_it_is_not_a_php_tag()
    {
        $this->beConstructedFromString("critical");

        $this->getConstraint()->shouldReturn(null);
    }
}
