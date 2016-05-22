<?php

namespace Cjm\Fake\Behat;

use Behat\Behat\Tester\ScenarioTester as ScenarioTesterInterface;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface as Scenario;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\IntegerTestResult;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\SuccessfulSetup;
use Behat\Testwork\Tester\Setup\SuccessfulTeardown;
use Behat\Testwork\Tester\Setup\Teardown;

final class ScenarioTester implements ScenarioTesterInterface
{
    /**
     * @return Setup
     */
    public function setUp(Environment $env, FeatureNode $feature, Scenario $scenario, $skip)
    {
        return new SuccessfulSetup();
    }

    /**
     * @return TestResult
     */
    public function test(Environment $env, FeatureNode $feature, Scenario $scenario, $skip)
    {
        if ($skip) {
            return new IntegerTestResult(TestResult::SKIPPED);
        }

        return new IntegerTestResult(TestResult::PASSED);
    }

    /**
     * @return Teardown
     */
    public function tearDown(Environment $env, FeatureNode $feature, Scenario $scenario, $skip, TestResult $result)
    {
        return new SuccessfulTeardown();
    }
}