<?php

namespace Cjm\Behat\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface as Scenario;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Cjm\Behat\TestFactory;
use Cjm\Testing\SemVer\Tag;
use Cjm\Testing\SemVer\Test;
use Cjm\Testing\SemVer\TestMatcher;

final class SkippingScenarioTester implements ScenarioTester
{
    /**
     * @var ScenarioTester
     */
    private $inner;

    /**
     * @var TestMatcher
     */
    private $matcher;
    /**
     * @var TestFactory
     */
    private $testFactory;

    public function __construct(
        ScenarioTester $inner,
        TestMatcher $matcher,
        TestFactory $testFactory
    )
    {
        $this->inner = $inner;
        $this->matcher = $matcher;
        $this->testFactory = $testFactory;
    }

    /**
     * @return Setup
     */
    public function setUp(Environment $env, FeatureNode $feature, Scenario $scenario, $skip)
    {
        return $this->inner->setUp($env, $feature, $scenario, $this->shouldSkip($skip, $scenario));
    }

    /**
     * @return TestResult
     */
    public function test(Environment $env, FeatureNode $feature, Scenario $scenario, $skip)
    {
        return $this->inner->test($env, $feature, $scenario, $this->shouldSkip($skip, $scenario));
    }

    /**
     * @return Teardown
     */
    public function tearDown(Environment $env, FeatureNode $feature, Scenario $scenario, $skip, TestResult $result)
    {
        return $this->inner->tearDown($env, $feature, $scenario, $this->shouldSkip($skip, $scenario), $result);
    }

    /**
     * @return bool
     */
    private function shouldSkip($skip, Scenario $scenario)
    {
        return $skip || !$this->matcher->matches($this->testFactory->fromScenario($scenario));
    }
}
