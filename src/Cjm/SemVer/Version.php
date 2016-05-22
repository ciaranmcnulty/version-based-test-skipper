<?php

namespace Cjm\SemVer;

final class Version
{
    private $string;

    private function __construct($string)
    {
        if (preg_match('/^(?<version>[.0-9]+)/', $string, $matches)) {
            $string = $matches['version'];
        }
        $this->string = $string;
    }

    /**
     * @param string
     *
     * @return Version
     */
    public static function fromString($string)
    {
        return new Version($string);
    }

    public function asString()
    {
        return $this->string;
    }
}
