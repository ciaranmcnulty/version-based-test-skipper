<?php

namespace spec\Cjm\Behat\Tester;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Behat\Testwork\Tester\SpecificationTester;
use Cjm\Behat\TestFactory;
use Cjm\Testing\SemVer\Test;
use Cjm\Testing\SemVer\TestMatcher;
use Cjm\Testing\SemVer\VersionBasedTestMatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkippingFeatureTesterSpec extends ObjectBehavior
{
    function let(
        SpecificationTester $inner, TestMatcher $testMatcher, TestFactory $testFactory
    )
    {
        $testFactory->fromTaggedNode(Argument::any())->willReturn(Test::taggedWith([]));
        $testMatcher->matches(Argument::any())->willReturn(true);


        $this->beConstructedWith($inner, $testMatcher, $testFactory);
    }

    function it_is_a_feature_tester()
    {
        $this->shouldHaveType('Behat\Testwork\Tester\SpecificationTester');
    }

    function it_passes_through_result_of_setup_when_versions_match(
        SpecificationTester $inner,
        Environment $env, FeatureNode $feature,
        Setup $setUp
    )
    {
        $inner->setUp($env, $feature, false)->willReturn($setUp);

        $this->setUp($env, $feature, false)->shouldReturn($setUp);
    }

    function it_skips_setup_when_versions_do_not_match(
        SpecificationTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature,
        Setup $setUp
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->setUp($env, $feature, true)->willReturn($setUp);

        $this->setUp($env, $feature, false)->shouldReturn($setUp);
    }

    function it_passes_through_result_of_test_when_versions_match(
        SpecificationTester $inner,
        Environment $env, FeatureNode $feature,
        TestResult $testResult
    )
    {
        $inner->test($env, $feature, false)->willReturn($testResult);

        $this->test($env, $feature, false)->shouldReturn($testResult);
    }

    function it_skips_test_when_versions_do_not_match(
        SpecificationTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature,
        TestResult $testResult
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->test($env, $feature, true)->willReturn($testResult);

        $this->test($env, $feature, false)->shouldReturn($testResult);
    }

    function it_passes_through_result_of_teardown_when_versions_match(
        SpecificationTester $inner,
        Environment $env, FeatureNode $feature, TestResult $testResult,
        Teardown $tearDown
    )
    {
        $inner->tearDown($env, $feature, false, $testResult)->willReturn($tearDown);

        $this->tearDown($env, $feature, false, $testResult)->shouldReturn($tearDown);
    }

    function it_skips_teardown_when_versions_do_not_match(
        SpecificationTester $inner, TestMatcher $testMatcher,
        Environment $env, FeatureNode $feature, TestResult $testResult,
        Teardown $tearDown
    )
    {
        $testMatcher->matches(Argument::any())->willReturn(false);
        $inner->tearDown($env, $feature, true, $testResult)->willReturn($tearDown);

        $this->tearDown($env, $feature, false, $testResult)->shouldReturn($tearDown);
    }
}
