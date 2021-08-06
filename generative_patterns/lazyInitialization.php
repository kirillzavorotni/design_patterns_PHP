<?php

class User
{
    private $name = null;
    private $age = null;
    private $gender = null;

    public function __construct(string $name = 'Kiryl', int $age = 31, string $gender = 'male')
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getGender()
    {
        return $this->gender;
    }
}

class LazyInitialization
{
    private $user = null;

    public function __construct()
    {
        // $this->user = new User();

        // Оставляем пустым что-бы при создании этого класса
        // мы не делали $this->user = new User() потому как это
        // может быть на не нужно. Может мы хотим использовать только метод doSomeAction1() и не хотим делать $this->user = new User()
        // Короче что-бы например не лнзть в базу при
        // каждой инициализации нового объекта
    }

    public function getUser()
    {
        if (is_null($this->user)){
            $this->user = new User();
        }

        return $this->user;
    }

    public function doSomeAction1()
    {
        return 1+2;
    }

    public function doSomeAction2()
    {
        $arr = [3,1,4,6,7];
        return sort($arr);
    }
}

$lazy = new LazyInitialization();

$user[] = $lazy->getUser()->getName();
$user[] = $lazy->getUser()->getAge();
$user[] = $lazy->getUser()->getGender();

var_dump($user);

