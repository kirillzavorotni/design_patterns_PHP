<?php

interface OrderUpdateInterface
{
    public function run(Order $order, array $orderData): Order;
}



class Order
{

}

final class OrderUpdate implements OrderUpdateInterface
{
    public function run(Order $order, array $orderData): Order
    {
        var_dump('Base order update');

        return $order;
    }
}

abstract class OrderUpdateDecoratorAbstract implements OrderUpdateInterface
{
    protected $decoratedObject;

    public function __construct(OrderUpdateInterface $decoratedObject)
    {
        $this->decoratedObject = $decoratedObject;
    }

    public function run(Order $order, array $orderData): Order
    {
        $this->actionBefore();
        $this->actionMain($order, $orderData);
        $this->actionAfter();

        return $order;
    }

    protected function actionBefore()
    {
        // TODO: do action before
    }

    protected function actionAfter()
    {
        // TODO: do action after
    }

    protected function actionMain($order, $orderData)
    {
        $this->decoratedObject->run($order, $orderData);
    }
}

class OrderUpdateDecoratorLogger extends OrderUpdateDecoratorAbstract
{
    protected function actionBefore()
    {
        var_dump('Logged before');
    }

    protected function actionAfter()
    {
        var_dump('Logged after');
    }
}

class OrderUpdateDecoratorUserNotification extends OrderUpdateDecoratorAbstract
{
    protected function actionAfter()
    {
        var_dump('User notify');
    }
}

class OrderUpdateDecoratorManagerNotification extends OrderUpdateDecoratorAbstract
{
    protected function actionAfter()
    {
        var_dump('Manager notify');
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
        $order = new Order();
        $orderData = [];

        $orderDecoratorLogger = new OrderUpdateDecoratorLogger(new OrderUpdate());
        $orderUpdateDecoratorUserNotification = new OrderUpdateDecoratorUserNotification($orderDecoratorLogger);
        $orderUpdateDecoratorManagerNotification = new OrderUpdateDecoratorManagerNotification($orderUpdateDecoratorUserNotification);
        $orderUpdateDecoratorManagerNotification->run($order, $orderData);
    }
}

new App();