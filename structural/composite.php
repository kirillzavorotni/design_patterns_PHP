<?php

interface CompositeItemInterface
{
    public function calcPrice(): float;
}

interface CompositeInterface extends CompositeItemInterface
{
    public function setChildItem(CompositeItemInterface $item);
}



trait CompositeTrait
{
    private $compositePriceItems = [];

    public function setChildItem(CompositeItemInterface $item)
    {
        $this->compositePriceItems[] = $item;
    }

    public function calcPrice(): float
    {
        if ($this->price) {
            return $this->price;
        }

        $this->price = 0;

        foreach ($this->compositePriceItems as $compositePriceItem) {
            $this->price += $compositePriceItem->calcPrice();
        }

        return $this->price;
    }
}



class Order implements CompositeInterface
{
    use CompositeTrait;

    public $type = 'order';
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

class Product implements CompositeInterface
{
    use CompositeTrait;

    public $type = 'product';
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

class Ingredient implements CompositeItemInterface
{
    use CompositeTrait;

    public $type = 'ingredient';
    public $name;
    public $price;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->price = mt_rand(10, 100) / 10;

        var_dump([
            'type' => $this->type,
            'name' => $this->name,
            'price' => $this->price
        ]);
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
        $ingredient1 = new Ingredient('ingredient_1');
        $ingredient2 = new Ingredient('ingredient_2');
        $ingredient3 = new Ingredient('ingredient_3');

        $product1 = new Product('product_1');
        $product2 = new Product('product_2');

        $product1->setChildItem($ingredient1);
        $product1->setChildItem($ingredient2);

        $product2->setChildItem($ingredient3);
        $product2->setChildItem($ingredient1);

        var_dump($product1);
        var_dump($product2);

        $order1 = new Order('order_1');
        $order1->setChildItem($product1);
        $order1->setChildItem($product2);

        var_dump([
            'product_1 price' => $product1->calcPrice(),
            'product_2 price' => $product2->calcPrice()
        ]);

        var_dump([
            'order_1 price' => $order1->calcPrice()
        ]);
    }
}

new App();