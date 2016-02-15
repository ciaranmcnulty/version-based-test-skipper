<?php

namespace Cjm\SemVer;

interface VersionDetector
{
    /**
     * @return Version
     */
    public function getVersion();
}
