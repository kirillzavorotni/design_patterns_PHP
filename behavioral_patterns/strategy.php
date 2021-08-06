<?php

interface StrategyInterface
{
    public function doStrategy(Array $array = []): array;
}

class strategyA implements StrategyInterface
{
    public function doStrategy(Array $array = []): array
    {
        $array[] = "itemA";
        return $array;
    }
}

class strategyB implements StrategyInterface
{
    public function doStrategy(Array $array = []): array
    {
        $array[] = "itemB";
        return $array;
    }
}

class Context
{
    private $strategy;

    public function __construct($strategy)
    {
        $this->setStrategy($strategy);
    }

    public function setStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function doSomething()
    {
        var_dump($this->strategy->doStrategy());
    }
}

class App
{
    public function __construct()
    {
        $context = new Context(new strategyA());
        $context->doSomething();

        $context->setStrategy(new strategyB());
        $context->doSomething();
    }
}

new App();