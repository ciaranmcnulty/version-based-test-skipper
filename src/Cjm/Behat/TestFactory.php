<?php

namespace Cjm\Behat;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Gherkin\Node\TaggedNodeInterface;
use Cjm\Testing\SemVer\Test;

class TestFactory
{
    private $tagConstructor = ['Cjm\Testing\Semver\Tag', 'fromString'];

    /**
     * @return Test
     */
    public function fromTaggedNode(TaggedNodeInterface $taggedNode)
    {
        return Test::taggedWith(
            array_map(
                $this->tagConstructor,
                $taggedNode->getTags()
            )
        );
    }
}
