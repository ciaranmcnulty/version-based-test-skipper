<?php


namespace Cjm\Fake\SemVer;

use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector as VersionDetectorInterface;

final class VersionDetector implements VersionDetectorInterface
{
    /**
     * @var Version
     */
    private $version;

    public function __construct(Version $version)
    {
        $this->version = $version;
    }

    /**
     * @return Version
     */
    public function getVersion()
    {
        return $this->version;
    }
}