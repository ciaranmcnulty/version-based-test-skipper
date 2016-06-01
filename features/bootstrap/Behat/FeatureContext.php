<?php

namespace Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Runtime\RuntimeFeatureTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Environment\StaticEnvironment;
use Behat\Testwork\Suite\GenericSuite;
use Behat\Testwork\Tester\Result\TestResult;
use Cjm\Behat\Tester\SkippingFeatureTester;
use Cjm\Behat\TestFactory;
use Cjm\Composer\ConstraintMatcher;
use Cjm\Fake\Behat\FeatureTester;
use Cjm\Php\VersionDetector;
use Cjm\SemVer\Version;
use Cjm\Testing\SemVer\VersionBasedTestMatcher;
use Composer\Semver\Semver;

class FeatureContext implements Context, SnippetAcceptingContext
{
    private $version;
    private $feature;
    private $testResult;

    /**
     * @Given I have a test tagged :tag
     */
    public function iHaveATestTagged($tag)
    {
        $this->feature = new FeatureNode('title', '', [$tag], null,[],'','en','',1);
    }

    /**
     * @Given the current major version of PHP is :version
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
        $tester = new SkippingFeatureTester(
            new FeatureTester(),
            new VersionBasedTestMatcher(
                new VersionDetector(),
                new ConstraintMatcher(new Semver())
            ),
            new TestFactory()
        );
        $env = new StaticEnvironment(new GenericSuite('',[]));

        $this->testResult = $tester->test($env, $this->feature, false);
    }

    /**
     * @Then the test should not be skipped
     */
    public function theTestShouldNotBeSkipped()
    {
        if (!$this->testResult->isPassed()) {
            throw new \Exception('Feature was not passed as expected');
        }
    }

    /**
     * @Then the test should be skipped
     */
    public function theTestShouldBeSkipped()
    {
        if ($this->testResult->getResultCode() !== TestResult::SKIPPED) {
            throw new \Exception('Feature was not skipped as expected');
        }
    }
}
