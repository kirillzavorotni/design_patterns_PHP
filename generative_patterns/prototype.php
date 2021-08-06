<?php

class Order
{
    private $id;
    public $deliveryDate;
    private $client;

    public function __construct($id, $deliveryDate, Client $client)
    {
        $this->id = $id;
        $this->deliveryDate = $deliveryDate;
        $this->client = $client;
    }

    public function __clone()
    {
        $this->id = $this->id . '_clone';
        $this->deliveryDate = clone $this->deliveryDate;
        $this->client->addOrder($this);
    }
}

class Client
{
    private $id;
    private $orders = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
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
        $client = new Client(25);
        $deliveryDate = date_create('2021-08-05 15:00');
        $order = new Order(123, $deliveryDate, $client);
        $client->addOrder($order);

        $clonedOrder = clone $order;

        date_add($clonedOrder->deliveryDate, date_interval_create_from_date_string('1 days'));

        var_dump($client);
        var_dump($order);

        var_dump($clonedOrder);
    }
}

new App();