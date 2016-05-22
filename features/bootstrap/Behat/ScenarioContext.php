<?php

namespace Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\ScenarioNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Testwork\Environment\StaticEnvironment;
use Behat\Testwork\Suite\GenericSuite;
use Behat\Testwork\Tester\Result\TestResult;
use Cjm\Behat\Tester\SkippingScenarioTester;
use Cjm\Composer\ConstraintMatcher;
use Cjm\Fake\Behat\ScenarioTester;
use Cjm\Php\VersionDetector;
use Cjm\SemVer\Version;
use Cjm\Testing\SemVer\TestMatcher;
use Composer\Semver\Semver;

/**
 * Defines application features from the specific context.
 */
class ScenarioContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ScenarioTester
     */
    private $tester;
    private $version;
    private $scenario;

    /**
     * @Given I have a test tagged :tag
     */
    public function iHaveATestTagged($tag)
    {
        $this->scenario = new ScenarioNode('title', [$tag], [], '', 0);
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
        $this->tester = new SkippingScenarioTester(
            new ScenarioTester(),
            new TestMatcher(
                new VersionDetector(),
                new ConstraintMatcher(new Semver())
            )
        );
    }

    /**
     * @Then the test should not be skipped
     */
    public function theTestShouldNotBeSkipped()
    {
        $testResult = $this->execute();

        if (!$testResult->isPassed()) {
            throw new \Exception('Scenario was not passed as expected');
        }
    }

    /**
     * @Then the test should be skipped
     */
    public function theTestShouldBeSkipped()
    {
        $testResult = $this->execute();

        if ($testResult->getResultCode() !== TestResult::SKIPPED) {
            throw new \Exception('Scenario was not skipped as expected');
        }
    }

    /**
     * Exercises the scenario and returns the result
     *
     * @return TestResult
     */
    private function execute()
    {
        $env = new StaticEnvironment(new GenericSuite('',[]));
        $feature = new FeatureNode('','',[],null,[],'','en','','');
        $skip = false;

        return $this->tester->test($env, $feature, $this->scenario, $skip);
    }
}
