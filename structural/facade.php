<?php

class Order
{
    public $id = 1;
    public $client_id;
    public $delivery_date;

    public function save()
    {
        var_dump([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'delivery_date' => $this->delivery_date
        ]);
    }
}

class Request
{
    public $client_id;
    public $delvery_date;

    public function __construct($client_id = 12, $delivery_date = '2021-08-06 16:00')
    {
        $this->client_id = $client_id;
        $this->delvery_date = $delivery_date;
    }

    public function all()
    {
        return [
            'client_id' => $this->client_id,
            'delivery_date' => $this->delvery_date
        ];
    }
}

class OrderSaveClient
{
    private $order;
    private $data;

    public function __construct($order, $data)
    {
        $this->order = $order;
        $this->data = $data;
    }

    public function run()
    {
        if ($this->data['client_id']) {
            $this->order->client_id = $this->data['client_id'];
        }
    }
}

class OrderSaveDate
{
    private $order;
    private $data;

    public function __construct($order, $data)
    {
        $this->order = $order;
        $this->data = $data;
    }

    public function run()
    {
        if ($this->data['delivery_date']) {
            $this->order->delivery_date = $this->data['delivery_date'];
        }
    }
}

class SaveOrderFacade
{
    public function save($order, $data)
    {
        (new OrderSaveClient($order, $data))->run();
        (new OrderSaveDate($order,  $data))->run();
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
        $request = new Request();

        // We got order for example from controller
        $order = new Order();
        $data = $request->all();

        (new SaveOrderFacade())->save($order, $data);

        $order->save();
    }
}

new App();