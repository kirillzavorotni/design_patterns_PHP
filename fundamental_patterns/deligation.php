<?php

interface MessengerInterface
{
    public function setSender($value): MessengerInterface;
    public function setRecipient($value): MessengerInterface;
    public function setMessage($value): MessengerInterface;
    public function send(): bool;
}

abstract class AbstractMessenger implements MessengerInterface
{
    protected $sender;
    protected $recipient;
    protected $message;

    public function setSender($value): MessengerInterface
    {
        $this->sender = $value;
        return $this;
    }

    public function setRecipient($value): MessengerInterface
    {
        $this->recipient = $value;
        return $this;
    }

    public function setMessage($value): MessengerInterface
    {
        $this->message = $value;
        return $this;
    }

    public function send(): bool
    {
        echo " Message: " . $this->message;
        return true;
    }
}

class MailMessenger extends AbstractMessenger
{
    public function send(): bool
    {
        echo "Hello from mail messenger.";
        return parent::send();
    }
}

class SmsMessenger extends AbstractMessenger
{
    public function send(): bool
    {
        echo "Hello from sms messenger.";
        return parent::send();
    }
}

class AppMessenger implements MessengerInterface
{
    private $messenger;

    public function __construct()
    {
        $this->sendByMail();
    }

    public function sendByMail()
    {
        $this->messenger = new MailMessenger();
        return $this->messenger;
    }

    public function sendBySms()
    {
        $this->messenger = new SmsMessenger();
        return $this->messenger;
    }

    public function setSender($value): MessengerInterface
    {
        $this->messenger->setSender($value);
        return $this->messenger;
    }

    public function setRecipient($value): MessengerInterface
    {
        $this->messenger->setRecipient($value);
        return $this->messenger;
    }

    public function setMessage($value): MessengerInterface
    {
        $this->messenger->setMessage($value);
        return $this->messenger;

    }

    public function send(): bool
    {
        $this->messenger->send();
        return true;
    }
}

class App
{
    public function run()
    {
        $messenger = new AppMessenger();
        $messenger->setSender('aaa@a.com')
            ->setRecipient('bbb@b.com')
            ->setMessage('Hello world!!!')
            ->send();

        var_dump($messenger);

        $messenger->sendBySms()
            ->setSender('ccc@c.com')
            ->setRecipient('ddd@d.com')
            ->setMessage('Hello world!!!')
            ->send();

        var_dump($messenger);
    }
}

$app = new App();
$app->run();