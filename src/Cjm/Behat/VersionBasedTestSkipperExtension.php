<?php

namespace Cjm\Behat\VersionBasedtestSkipperExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Cjm\Behat\Tester\SkippingScenarioTester;
use Cjm\Composer\ConstraintMatcher;
use Cjm\Php\VersionDetector;
use Cjm\Testing\SemVer\TestMatcher;
use Composer\Semver\Semver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class VersionBasedTestSkipperExtension implements Extension
{
    /**
     * Decorate the existing scenariotester with ours
     */
    public function process(ContainerBuilder $container)
    {
        $scenarioTester = $container->findDefinition('tester.scenario');
        $skippingTester = $container->findDefinition('versionbasedtestskipper.tester.scenario.skipping');

        $container->setDefinition('versionbasedtestskipper.tester.scenario.inner', $scenarioTester);
        $container->setDefinition('tester.scenario', $skippingTester);
    }

    public function getConfigKey()
    {
        return 'versionbasedtestskipper';
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * Basic service definitions
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $container->setDefinition('versionbasedtestskipper.tester.scenario.skipping', new Definition(
            SkippingScenarioTester::class,
            [
                new Reference('versionbasedtestskipper.tester.scenario.inner'),
                new Reference('versionbasedtestskipper.testmatcher')
            ]
        ));

        $container->setDefinition('versionbasedtestskipper.testmatcher', new Definition(
            TestMatcher::class,
            [
                new Reference('versionbasedtestskipper.versiondetector'),
                new Reference('versionbasedtestskipper.constraintmatcher')
            ]
        ));

        $container->setDefinition('versionbasedtestskipper.versiondetector', new Definition(
            VersionDetector::class
        ));

        $container->setDefinition('versionbasedtestskipper.constraintmatcher', new Definition(
            ConstraintMatcher::class,
            [ new Reference('versionbasedtestskipper.composer.semver') ]
        ));

        $container->setDefinition('versionbasedtestskipper.composer.semver', new Definition(
            Semver::class
        ));
    }
}