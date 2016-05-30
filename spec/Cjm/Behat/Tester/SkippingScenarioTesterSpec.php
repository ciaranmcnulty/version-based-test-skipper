<?php

namespace spec\Cjm\Behat\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Cjm\Behat\TestFactory;
use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector;
use Cjm\Testing\SemVer\Test;
use Cjm\Testing\SemVer\TestMatcher;
use Cjm\Testing\SemVer\VersionBasedTestMatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkippingScenarioTesterSpec extends ObjectBehavior
{
    function let (
        ScenarioTester $inner, TestMatcher $testMatcher, TestFactory $testFactory
    )
    {
        $testFactory->fromTaggedNode(Argument::any())->willReturn(Test::taggedWith([]));
        $testMatcher->matches(Argument::any())->willReturn(true);

        $this->beConstructedWith($inner, $testMatcher, $testFactory);
    }

    function it_is_a_scenario_tester()
    {
        $this->shouldHaveType('Behat\Behat\Tester\ScenarioTester');
    }

    function it_passes_through_result_of_setup_when_versions_match(
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        Setup $result
    )
    {
        $inner->setUp($env, $feature, $scenario, false)->willReturn($result);

        $this->setup($env, $feature, $scenario, false)->shouldReturn($result);
    }

    function it_skips_setup_when_versions_do_not_match(
        ScenarioTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        Setup $result
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->setUp($env, $feature, $scenario, true)->willReturn($result);

        $this->setup($env, $feature, $scenario, false)->shouldReturn($result);
    }

    function it_passes_the_result_of_test_when_versions_match(
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $result
    )
    {
        $inner->test($env, $feature, $scenario, false)->willReturn($result);

        $this->test($env, $feature, $scenario, false)->shouldReturn($result);
    }

    function it_skips_the_test_when_versions_do_not_match(
        ScenarioTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $result
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->test($env, $feature, $scenario, true)->willReturn($result);

        $this->test($env, $feature, $scenario, false)->shouldReturn($result);
    }

    function it_passes_through_result_of_teardown_when_versions_match(
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $testResult, Teardown $result
    )
    {
        $inner->tearDown($env, $feature, $scenario, false, $testResult)->willReturn($result);

        $this->tearDown($env, $feature, $scenario, false, $testResult)->shouldReturn($result);
    }

    function it_skips_teardown_when_versions_do_not_match(
        ScenarioTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $testResult, Teardown $result
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->tearDown($env, $feature, $scenario, true, $testResult)->willReturn($result);

        $this->tearDown($env, $feature, $scenario, false, $testResult)->shouldReturn($result);
    }
}
