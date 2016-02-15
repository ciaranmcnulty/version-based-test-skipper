<?php

namespace spec\Cjm\SemVer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VersionSpec extends ObjectBehavior
{
    function it_can_be_represented_as_a_string()
    {
        $this->beConstructedFromString('5.6.1');
        $this->asString()->shouldReturn('5.6.1');
    }
}
