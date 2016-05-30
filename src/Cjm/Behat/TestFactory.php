<?php

namespace Cjm\Behat;

use Behat\Gherkin\Node\ScenarioInterface;
use Cjm\Testing\SemVer\Test;

class TestFactory
{
    public function fromScenario(ScenarioInterface $scenario)
    {
        return Test::taggedWith(
            array_map(
                ['Cjm\Testing\Semver\Tag', 'fromString'],
                $scenario->getTags()
            )
        );
    }
}
