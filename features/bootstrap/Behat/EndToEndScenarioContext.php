<?php

namespace Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class EndToEndScenarioContext implements Context
{
    private $scenario;
    private $output;

    /**
     * @Given I have a test tagged :tag
     */
    public function iHaveATestTagged($tag)
    {
        if ($tag == "php:~5.0") {
            $this->scenario = 'features/end-to-end-scenario-test.feature:6';
        }
        elseif ($tag == "php:~7.0") {
            $this->scenario = 'features/end-to-end-scenario-test.feature:10';
        }
        else {
            throw new \Exception('Cannot find a fixture scenario for tag ' . $tag);
        }
    }

    /**
     * @Given the current major version of PHP is :version
     */
    public function theCurrentVersionOfPhpIs($version)
    {
        if (floor(PHP_VERSION) != floor($version)) {
            throw new \Exception('Can only run end-to-end if PHP version matches ' . $version);
        }
    }

    /**
     * @When I run the tests
     */
    public function iRunTheTests()
    {
        $this->output = shell_exec('bin/behat -c "features/bootstrap/dummy/behat.yml" features/bootstrap/dummy/' . $this->scenario);
    }

    /**
     * @Then the test should be skipped
     */
    public function theTestShouldBeSkipped()
    {
        if (!preg_match('/1 skipped/', $this->output)) {
            throw new \Exception('Test was unexpectedly not skipped');
        }
    }
}
