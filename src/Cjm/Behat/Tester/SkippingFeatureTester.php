<?php

namespace Cjm\Behat\Tester;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Behat\Testwork\Tester\SpecificationTester;
use Cjm\Behat\TestFactory;
use Cjm\Testing\SemVer\TestMatcher;

class SkippingFeatureTester implements SpecificationTester
{
    /**
     * @var SpecificationTester
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
        SpecificationTester $inner,
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
    public function setUp(Environment $env, $spec, $skip)
    {
        return $this->inner->setUp($env, $spec, $this->shouldSkip($skip, $spec));
    }

    /**
     * @return TestResult
     */
    public function test(Environment $env, $spec, $skip)
    {
        return $this->inner->test($env, $spec, $this->shouldSkip($skip, $spec));
    }

    /**
     * @return Teardown
     */
    public function tearDown(Environment $env, $spec, $skip, TestResult $result)
    {
        return $this->inner->tearDown($env, $spec, $this->shouldSkip($skip, $spec), $result);
    }

    /**
     * @return bool
     */
    private function shouldSkip($skip, $feature)
    {
        return $skip || !$this->matcher->matches($this->testFactory->fromTaggedNode($feature));
    }
}
