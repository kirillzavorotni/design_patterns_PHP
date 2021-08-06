<?php

interface PropertyContainerInterface
{
    function addProperty($propertyName, $propertyValue);
    function setProperty($propertyName, $propertyValue);
    function getProperty($propertyName);
    function removeProperty($propertyName);
}

class PropertyContainer implements PropertyContainerInterface
{
    public $properties = [];

    function addProperty($propertyName, $propertyValue = null)
    {
        if(!isset($propertyName) || array_key_exists($propertyName, $this->properties)) return false;

        return $this->properties[$propertyName] = $propertyValue;
    }

    function setProperty($propertyName, $propertyValue = null)
    {
        if(!isset($propertyName) || !array_key_exists($propertyName, $this->properties)) return false;

        return $this->properties[$propertyName] = $propertyValue;
    }

    function getProperty($propertyName)
    {
        return isset($propertyName) && array_key_exists($propertyName, $this->properties) ? $this->properties[$propertyName] : false;
    }

    function removeProperty($propertyName)
    {
        if (isset($propertyName) && array_key_exists($propertyName, $this->properties)) {
            unset($this->properties[$propertyName]);
            return true;
        }

        return false;
    }
}

class MyCustomPropertyContainer extends PropertyContainer
{
    function getPropertyList()
    {
        return $this->properties;
    }
}



class App extends MyCustomPropertyContainer
{
    public function __construct()
    {
        $this->addProperty('productName', 'phone');
        $this->addProperty('productColor', 'red');

        $this->setProperty('productColor', 'green');

        $this->removeProperty('productColor');
    }

    public function showProperties()
    {
        var_dump($this->getPropertyList());
        var_dump($this->getProperty('productColor'));
        exit;
    }
}

$app = new App();
$app->showProperties();
