<?php

namespace Cjm\SemVer;

final class Version
{
    private $string;

    private function __construct()
    {
    }

    /**
     * @param string
     *
     * @return Version
     */
    public static function fromString($string)
    {
        $version = new Version();
        $version->string = $string;

        return $version;
    }

    public function asString()
    {
        return $this->string;
    }
}
