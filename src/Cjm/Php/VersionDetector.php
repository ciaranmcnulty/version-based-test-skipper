<?php

namespace Cjm\Php;

use Cjm\SemVer\Version;
use Cjm\SemVer\VersionDetector as VersionDetectorInterface;

class VersionDetector implements VersionDetectorInterface
{
    /**
     * @return Version
     */
    public function getVersion()
    {
        return Version::fromString(PHP_VERSION);
    }
}