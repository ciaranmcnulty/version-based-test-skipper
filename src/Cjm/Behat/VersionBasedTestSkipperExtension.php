<?php

namespace Cjm\Behat\VersionBasedtestSkipperExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
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

        $specificationTester = $container->findDefinition('tester.specification');
        $skippingTester = $container->findDefinition('versionbasedtestskipper.tester.specification.skipping');

        $container->setDefinition('versionbasedtestskipper.tester.specification.inner', $specificationTester);
        $container->setDefinition('tester.specification', $skippingTester);
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
            'Cjm\Behat\Tester\SkippingScenarioTester',
            [
                new Reference('versionbasedtestskipper.tester.scenario.inner'),
                new Reference('versionbasedtestskipper.testmatcher'),
                new Reference('versionbasedtestskipper.testfactory')
            ]
        ));

        $container->setDefinition('versionbasedtestskipper.tester.specification.skipping', new Definition(
            'Cjm\Behat\Tester\SkippingFeatureTester',
            [
                new Reference('versionbasedtestskipper.tester.specification.inner'),
                new Reference('versionbasedtestskipper.testmatcher'),
                new Reference('versionbasedtestskipper.testfactory')
            ]
        ));

        $container->setDefinition('versionbasedtestskipper.testmatcher', new Definition(
            'Cjm\Testing\SemVer\VersionBasedTestMatcher',
            [
                new Reference('versionbasedtestskipper.versiondetector'),
                new Reference('versionbasedtestskipper.constraintmatcher')
            ]
        ));

        $container->setDefinition('versionbasedtestskipper.testfactory', new Definition(
            'Cjm\Behat\TestFactory'
        ));

        $container->setDefinition('versionbasedtestskipper.versiondetector', new Definition(
            'Cjm\Php\VersionDetector'
        ));

        $container->setDefinition('versionbasedtestskipper.constraintmatcher', new Definition(
            'Cjm\Composer\ConstraintMatcher',
            [ new Reference('versionbasedtestskipper.composer.semver') ]
        ));

        $container->setDefinition('versionbasedtestskipper.composer.semver', new Definition(
            'Composer\Semver\Semver'
        ));
    }
}