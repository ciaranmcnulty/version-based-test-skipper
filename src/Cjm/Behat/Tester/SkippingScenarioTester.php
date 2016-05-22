<?php

namespace Cjm\Behat\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface as Scenario;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Cjm\SemVer\Constraint;
use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\VersionDetector;

final class SkippingScenarioTester implements ScenarioTester
{
    /**
     * @var ScenarioTester
     */
    private $inner;

    /**
     * @var VersionDetector
     */
    private $versionDetector;

    /**
     * @var ConstraintMatcher
     */
    private $constraintMatcher;

    public function __construct(ScenarioTester $inner, VersionDetector $versionDetector, ConstraintMatcher $constraintMatcher)
    {
        $this->inner = $inner;
        $this->versionDetector = $versionDetector;
        $this->constraintMatcher = $constraintMatcher;
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
        $version = $this->versionDetector->getVersion();

        foreach ($scenario->getTags() as $tag) {

            if (preg_match('/php:(?<constraint>.*)/', $tag, $matches)) {
                $constraint = Constraint::fromString($matches['constraint']);

                if (!$this->constraintMatcher->match($constraint, $version)) {
                    return true;
                }
            }
        }

        return $skip;
    }
}
