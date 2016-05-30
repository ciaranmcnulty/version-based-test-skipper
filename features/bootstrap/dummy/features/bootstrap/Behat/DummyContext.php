<?php

namespace Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class DummyContext implements Context
{
    /**
     * @When The test passes
     */
    public function theTestPasses()
    {
        // noop
    }
}
