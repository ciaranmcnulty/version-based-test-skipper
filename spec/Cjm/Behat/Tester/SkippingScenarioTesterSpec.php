<?php

namespace spec\Cjm\Behat\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\SuccessfulSetup;
use Behat\Testwork\Tester\Setup\Teardown;
use Cjm\SemVer\ConstraintMatcher;
use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector;
use Cjm\Testing\SemVer\TestMatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkippingScenarioTesterSpec extends ObjectBehavior
{
    function let (
        ScenarioTester $inner, VersionDetector $versionDetector, ConstraintMatcher $constraintMatcher,
        ScenarioInterface $scenario
    )
    {
        $testMatcher = new TestMatcher($versionDetector->getWrappedObject(), $constraintMatcher->getWrappedObject());
        $this->beConstructedWith($inner, $testMatcher);

        $versionDetector->getVersion()->willReturn(Version::fromString('5.6.0'));

        $scenario->getTags()->willReturn([]);
    }

    function it_is_a_scenario_tester()
    {
        $this->shouldHaveType(ScenarioTester::class);
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
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        Setup $result
    )
    {
        $scenario->getTags()->willReturn(['php:~7.0']);

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
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $result
    )
    {
        $scenario->getTags()->willReturn(['php:~7.0']);

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
        ScenarioTester $inner,
        Environment $env, FeatureNode $feature, ScenarioInterface $scenario,
        TestResult $testResult, Teardown $result
    )
    {
        $scenario->getTags()->willReturn(['php:~7.0']);

        $inner->tearDown($env, $feature, $scenario, true, $testResult)->willReturn($result);

        $this->tearDown($env, $feature, $scenario, false, $testResult)->shouldReturn($result);
    }
}
