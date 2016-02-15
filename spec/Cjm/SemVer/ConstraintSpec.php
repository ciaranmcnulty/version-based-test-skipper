<?php

namespace spec\Cjm\SemVer;

use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\Version;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ConstraintSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromString("~5.6");
    }

    function it_can_be_represented_as_a_string()
    {
        $this->asString()->shouldReturn("~5.6");
    }

}
