<?php

namespace Cjm\Php;

use Cjm\SemVer\Version;
use PHPUnit\Framework\TestCase;

class VersionDetectorTest extends TestCase
{
    /**
     * @var \Cjm\SemVer\VersionDetector
     */
    private $versionDetector;

    public function setUp() : void
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
