<?php

namespace Cjm\Php;

use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector as VersionDetectorInterface;

class VersionDetectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VersionDetectorInterface
     */
    private $versionDetector;

    public function setUp()
    {
        $this->versionDetector = new VersionDetector();
    }

    public function testItIsAVersionDetector()
    {
        $this->assertInstanceOf(VersionDetectorInterface::class, $this->versionDetector);
    }

    public function testItReturnsTheCurrentPhpVersion()
    {
        $version = $this->versionDetector->getVersion();

        $this->assertEquals(Version::fromString(PHP_VERSION), $version);
    }
}