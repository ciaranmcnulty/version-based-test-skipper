<?php

namespace Cjm\Testing\SemVer;

interface TestMatcher
{
    /**
     * @return bool
     */
    public function matches(Test $test);
}