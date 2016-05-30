<?php

namespace Cjm\Behat;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Gherkin\Node\TaggedNodeInterface;
use Cjm\Testing\SemVer\Tag;
use Cjm\Testing\SemVer\Test;

class TestFactory
{
    /**
     * @return Test
     */
    public function fromTaggedNode(TaggedNodeInterface $taggedNode)
    {
        return Test::taggedWith(
            array_map(
                function($tag) {
                    return Tag::fromString($tag);
                },
                $taggedNode->getTags()
            )
        );
    }
}
