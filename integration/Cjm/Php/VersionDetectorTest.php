<?php

namespace Cjm\Php;

use Cjm\SemVer\Version;

class VersionDetectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Cjm\SemVer\VersionDetector
     */
    private $versionDetector;

    public function setUp()
    {
        $this->versionDetector = new VersionDetector();
    }

    public function testItIsAVersionDetector()
    {
        $this->assertInstanceOf('Cjm\SemVer\VersionDetector', $this->versionDetector);
    }

    public function testItReturnsTheCurrentPhpVersion()
    {
        $version = $this->versionDetector->getVersion();

        $this->assertEquals(Version::fromString(PHP_VERSION), $version);
    }
}