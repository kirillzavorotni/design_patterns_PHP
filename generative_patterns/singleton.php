<?php

trait SingletonTrait
{
    static private $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    static public function instance()
    {
        if (self::$instance && self::$instance instanceof self) {
            return self::$instance;
        }

        return self::$instance = new self();
    }


}

class DB
{
    use SingletonTrait;

    private $test;

    public function setTest($value)
    {
        $this->test = $value;
    }
}

$db1 = DB::instance();
$db1->setTest('test value 1');
$db2 = DB::instance();

var_dump([
    $db1,
    $db2,
    $db1 === $db2
]);

