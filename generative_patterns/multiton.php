<?php

interface MultitonInterface
{
    public static function instance(string $name): self;
}

trait MultitonTrait
{
    static private $instances = [];
    public $name;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    static public function instance(string $name): MultitonInterface
    {
        if (isset(self::$instances[$name]) && self::$instances[$name] instanceof self) {
            self::$instances[$name]->setName($name);
            return self::$instances[$name];
        }

        self::$instances[$name] = new self();
        self::$instances[$name]->setName($name);
        return self::$instances[$name];
    }

    public function setName($value)
    {
        $this->name = $value;
    }
}

class SimpleMultiton implements MultitonInterface
{
    use MultitonTrait;
}

class App
{
    public function __construct()
    {
        $mysql1 = SimpleMultiton::instance('Mysql');
        $mysql2 = SimpleMultiton::instance('Mysql');

        $mongo1 = SimpleMultiton::instance('Mongo');
        $mongo2 = SimpleMultiton::instance('Mongo');

        var_dump(
            [
                $mysql1,
                $mysql2,
                $mysql1 === $mysql2,
                $mongo1,
                $mongo2,
                $mongo1 === $mongo2
            ]
        );
    }
}

new App();