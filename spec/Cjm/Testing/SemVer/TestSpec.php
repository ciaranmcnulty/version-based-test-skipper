<?php

namespace spec\Cjm\Testing\SemVer;

use Cjm\SemVer\Constraint;
use Cjm\Testing\SemVer\Tag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedTaggedWith([Tag::fromString('php:~5.3'), Tag::fromString('critical')]);
    }

    function it_finds_constraints_from_php_version_tags()
    {
        $this->getConstraints()->shouldBeLike([Constraint::fromString('~5.3')]);
    }
}
