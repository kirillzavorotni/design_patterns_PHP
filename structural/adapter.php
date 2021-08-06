<?php

interface Library1Interface
{
    public function action1(string $string): string;
    public function action1_1(string $string): string;
}

interface Library2Interface
{
    public function action2(string $string): string;
    public function action2_2(string $string): string;
}



class Library1 implements Library1Interface
{
    public function action1(string $string): string
    {
        return ucfirst($string) . '_action1';
    }

    public function action1_1(string $string): string
    {
        return lcfirst($string) . '_action1_1';
    }
}

class Library2 implements Library2Interface
{
    public function action2(string $string): string
    {
        return ucwords($string) . '_action_2';
    }

    public function action2_2(string $string): string
    {
        return $string . '_action2_2';
    }
}



class Adapter implements Library1Interface
{
    private $adapter;

    public function __construct()
    {
        $this->adapter = new Library2();
    }

    public function action1(string $string): string
    {
        return $this->adapter->action2($string);
    }

    public function action1_1(string $string): string
    {
        return $this->adapter->action2_2($string);
    }
}



class App
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {
        $adapter = new Adapter();

        $string = 'abcdef';

        $res1[] = $adapter->action1($string);
        $res1[] = $adapter->action1_1($string);

        var_dump($res1);
    }
}

new App();