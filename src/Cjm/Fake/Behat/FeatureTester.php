<?php


namespace Cjm\Fake\Behat;


use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\IntegerTestResult;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\SuccessfulSetup;
use Behat\Testwork\Tester\Setup\SuccessfulTeardown;
use Behat\Testwork\Tester\Setup\Teardown;
use Behat\Testwork\Tester\SpecificationTester;

class FeatureTester implements SpecificationTester
{
    /**
     * @return Setup
     */
    public function setUp(Environment $env, $spec, $skip)
    {
        return new SuccessfulSetup();
    }

    /**
     * @return TestResult
     */
    public function test(Environment $env, $spec, $skip)
    {
        if ($skip) {
            return new IntegerTestResult(TestResult::SKIPPED);
        }

        return new IntegerTestResult(TestResult::PASSED);
    }

    /**
     * @return Teardown
     */
    public function tearDown(Environment $env, $spec, $skip, TestResult $result)
    {
        return new SuccessfulTeardown();
    }
}