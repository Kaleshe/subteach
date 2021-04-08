<?php


namespace Tests;


use Closure;
use Exception;

class TestMain
{
    private function __construct()
    {

    }

    public function it($description, Closure $test)
    {
        print("\n### Testing: $description\n");
        $test($this);
    }

    public function expect($condition)
    {
        if(!$condition)
        {
            throw new Exception("Condition failed ...");
        }
    }

    public function expectEquals($expected, $actual)
    {
        $this->expect($expected === $actual);
    }

    public static function runAll()
    {
        $test = new TestMain();
        ViewProfileTest::runTests($test);
    }
}