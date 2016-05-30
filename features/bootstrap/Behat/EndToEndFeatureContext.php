<?php

namespace Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class EndToEndFeatureContext implements Context
{
    private $feature;
    private $output;

    /**
     * @Given I have a test tagged :tag
     */
    public function iHaveATestTagged($tag)
    {
        if ($tag == "php:~5.6") {
            $this->feature = 'features/end-to-end-php5-test.feature';
        } elseif ($tag == "php:~7.0") {
            $this->feature = 'features/end-to-end-php7-test.feature';
        } else {
            throw new \Exception('Cannot find a fixture feature for tag ' . $tag);
        }
    }

    /**
     * @Given the current version of PHP is :version
     */
    public function theCurrentVersionOfPhpIs($version)
    {
        if (PHP_VERSION != $version) {
            throw new \Exception('Can only run end-to-end if PHP version matches ' . $version);
        }
    }

    /**
     * @When I run the tests
     */
    public function iRunTheTests()
    {
        $this->output = shell_exec('bin/behat -c "features/bootstrap/dummy/behat.yml" features/bootstrap/dummy/' . $this->feature);
    }

    /**
     * @Then the test should not be skipped
     */
    public function theTestShouldNotBeSkipped()
    {
        if (!preg_match('/1 passed/', $this->output)) {
            throw new \Exception('Test was unexpectedly not passed');
        }
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
