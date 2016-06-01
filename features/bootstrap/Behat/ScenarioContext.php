<?php

namespace Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Tester\ScenarioTester as ScenarioTesterInterface;
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
use Cjm\Behat\TestFactory;
use Cjm\Composer\ConstraintMatcher;
use Cjm\Fake\Behat\ScenarioTester;
use Cjm\Php\VersionDetector;
use Cjm\SemVer\Version;
use Cjm\Testing\SemVer\VersionBasedTestMatcher;
use Composer\Semver\Semver;

class ScenarioContext implements Context
{
    private $version;
    private $scenario;
    private $testResult;

    /**
     * @Given I have a test tagged :tag
     */
    public function iHaveATestTagged($tag)
    {
        $this->scenario = new ScenarioNode('title', [$tag], [], '', 0);
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
        $tester = new SkippingScenarioTester(
            new ScenarioTester(),
            new VersionBasedTestMatcher(
                new VersionDetector(),
                new ConstraintMatcher(new Semver())
            ),
            new TestFactory()
        );
        $env = new StaticEnvironment(new GenericSuite('',[]));
        $feature = new FeatureNode('','',[],null,[],'','en','','');
        $skip = false;

        $this->testResult =  $tester->test($env, $feature, $this->scenario, $skip);
    }

    /**
     * @Then the test should not be skipped
     */
    public function theTestShouldNotBeSkipped()
    {
        if (!$this->testResult->isPassed()) {
            throw new \Exception('Scenario was not passed as expected');
        }
    }

    /**
     * @Then the test should be skipped
     */
    public function theTestShouldBeSkipped()
    {
        if ($this->testResult->getResultCode() !== TestResult::SKIPPED) {
            throw new \Exception('Scenario was not skipped as expected');
        }
    }

}
