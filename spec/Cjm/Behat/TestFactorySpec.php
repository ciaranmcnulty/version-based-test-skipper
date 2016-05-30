<?php

namespace spec\Cjm\Behat;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Cjm\Testing\SemVer\Tag;
use Cjm\Testing\SemVer\Test;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestFactorySpec extends ObjectBehavior
{
    function it_can_create_a_test_from_a_scenario_with_tags(ScenarioInterface $scenario)
    {
        $scenario->getTags()->willReturn(['foo', 'bar']);

        $this->fromTaggedNode($scenario)->shouldBeLike(Test::taggedWith([Tag::fromString('foo'), Tag::fromString('bar')]));
    }

    function it_can_create_a_test_from_a_feature_with_tags(FeatureNode $feature)
    {
        $feature->getTags()->willReturn(['foo', 'bar']);

        $this->fromTaggedNode($feature)->shouldBeLike(Test::taggedWith([Tag::fromString('foo'), Tag::fromString('bar')]));
    }
}
