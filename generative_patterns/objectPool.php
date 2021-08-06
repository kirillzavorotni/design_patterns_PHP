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

interface ObjectOfObjectPoolInterface
{
    public function __clone();
}

class ObjectPool
{
    use SingletonTrait;

    private $prototypes = [];
    private $clone = [];

    public function addObject(ObjectOfObjectPoolInterface $object)
    {
        $key = $this->getObjectKey($object);
        $this->prototypes[$key] = $object;

        return $this;
    }

    public function getObjectKey($object)
    {
        if (is_object($object)) {
            $key = get_class($object);
        } elseif (is_string($object)) {
            $key = $object;
        } else {
            throw new \Exception('???');
        }

        return $key;
    }

    public function getObject(string $className)
    {
        $key = $this->getObjectKey($className);

        if (isset($this->clone[$key])) {
            return false;
        }

        if (empty($this->prototypes[$key])) {
            return null;
        }

        $this->clone[$key] = clone $this->prototypes[$key];

        return $this->clone[$key];
    }

    public function release(ObjectOfObjectPoolInterface &$object)
    {
        $key = $this->getObjectKey($object);

        unset($this->clone[$key]);

        $object = null;
    }
}

class User implements ObjectOfObjectPoolInterface
{
    public function __clone()
    {
    }
}

class CreditCard implements ObjectOfObjectPoolInterface
{
    public function __clone()
    {
    }
}

class Calculator implements ObjectOfObjectPoolInterface
{
    public function __clone()
    {
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
        $objectPool = ObjectPool::instance();

        $user = new User();
        $creditCard = new CreditCard();
        $calculator = new Calculator();

        $objectPool->addObject($user)
            ->addObject($creditCard)
            ->addObject($calculator);

        var_dump($objectPool);

        $objects[] = $objectPool->getObject(User::class);
        $objects[] = $objectPool->getObject(Calculator::class);
        $objects[] = $objectPool->getObject(User::class);

        var_dump($objects);

        $objectPool->release($calculator);

        var_dump($objectPool);
    }
}

new App();