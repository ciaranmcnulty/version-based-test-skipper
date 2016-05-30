<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cjm\SemVer\Version;
use Cjm\Testing\SemVer\Tag;
use Cjm\Testing\SemVer\Test;
use Cjm\Testing\SemVer\VersionBasedTestMatcher;

/**
 * Defines application features from the specific context.
 */
class CoreContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Test
     */
    private $scenario;

    /**
     * @var boolean
     */
    private $result;

    /**
     * @var Version
     */
    private $version;

    /**
     * @Given I have a test tagged :tagString
     */
    public function iHaveATestTagged($tagString)
    {
        $this->scenario = Test::taggedWith([Tag::fromString($tagString)]);
    }

    /**
     * @Given the current version of PHP is :version
     */
    public function theCurrentVersionOfPhpIs($version)
    {
        $this->version = Version::fromString($version);
    }

    /**
     * @When I run the tests
     */
    public function iRunTheTests()
    {
        $matcher = new VersionBasedTestMatcher(
            new \Cjm\Fake\SemVer\VersionDetector($this->version),
            new \Cjm\Fake\SemVer\ConstraintMatcher()
        );

        $this->result = $matcher->matches($this->scenario);
    }

    /**
     * @Then the test should not be skipped
     */
    public function theTestShouldNotBeSkipped()
    {
        if (!$this->result) {
            throw new Exception('Test was skipped when it should not be');
        }
    }

    /**
     * @Then the test should be skipped
     */
    public function theTestShouldBeSkipped()
    {
        if ($this->result) {
            throw new Exception('Test was not skipped when it should be');
        }
    }
}
