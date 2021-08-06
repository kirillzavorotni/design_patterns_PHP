<?php

interface ButtonInterface
{
    public function render();
}
interface CheckboxInterface
{
    public function render();
}
interface FieldInterface
{
    public function render();
}
interface AbstractFactoryInterface
{
    public function getButton(): ButtonInterface;
    public function getCheckbox(): CheckboxInterface;
    public function getField(): FieldInterface;
}
interface GuiKitFactoryInterface
{
    static public function build($type): AbstractFactoryInterface;
}


class BootstrapButton implements ButtonInterface
{
    public function render()
    {
        return __METHOD__;
    }
}
class BootstrapCheckbox implements CheckboxInterface
{
    public function render()
    {
        return __METHOD__;
    }
}
class BootstrapField implements FieldInterface
{
    public function render()
    {
        return __METHOD__;
    }
}

class JQueryButton implements ButtonInterface
{
    public function render()
    {
        return __METHOD__;
    }
}
class JQueryCheckbox implements CheckboxInterface
{
    public function render()
    {
        return __METHOD__;
    }
}
class JQueryField implements FieldInterface
{
    public function render()
    {
        return __METHOD__;
    }
}


class BootstrapFactory implements AbstractFactoryInterface
{
    public function getButton(): ButtonInterface
    {
        return new BootstrapButton();
    }

    public function getCheckbox(): CheckboxInterface
    {
        return new BootstrapCheckbox();
    }

    public function getField(): FieldInterface
    {
        return new BootstrapField();
    }
}

class JQueryFactory implements AbstractFactoryInterface
{
    public function getButton(): ButtonInterface
    {
        return new JQueryButton();
    }

    public function getCheckbox(): CheckboxInterface
    {
        return new JQueryCheckbox();
    }

    public function getField(): FieldInterface
    {
        return new JQueryField();
    }
}

class GuiKitFactory implements GuiKitFactoryInterface
{
    static public function build($type): AbstractFactoryInterface
    {
        switch ($type) {
            case 'bootstrap':
                $factory = new BootstrapFactory();
                break;
            case 'jquery':
                $factory = new JQueryFactory();
                break;
            default:
                throw new \Exception('неизвесный тип фабрики ' . $type);
        }

        return $factory;
    }
}

class App
{
    public function __construct($type)
    {
        $this->run($type);
    }

    public function run($type)
    {
        $factory = GuiKitFactory::build($type);

        $result = [
            $factory->getButton()->render(),
            $factory->getCheckbox()->render(),
            $factory->getField()->render()
        ];

        var_dump($result);
    }
}

new App('bootstrap');
new App('jquery');