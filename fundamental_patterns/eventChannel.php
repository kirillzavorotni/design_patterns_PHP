<?php

interface SubscriberInterface
{
    public function getName();
    public function notify($data);
}

interface PublisherInterface
{
    public function getTopic();
    public function publish($data);
}

interface EventChannelInterface
{
    public function publish($topic, $data);
    public function subscribe($topic, SubscriberInterface $subscriber);
}

class Subscriber implements SubscriberInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function notify($data)
    {
        echo "<br>" . $this->getName() . " notified about new publish: $data";
    }
}

class Publisher implements PublisherInterface
{
    private $topic;
    private $eventChannel;

    public function __construct($topic, $eventChannel)
    {
        $this->topic = $topic;
        $this->eventChannel = $eventChannel;
    }

    public function publish($data)
    {
        echo "<br><br>" . $this->getTopic() . " has published news: $data <br>";
        $this->eventChannel->publish($this->getTopic(), $data);
    }

    public function getTopic()
    {
        return $this->topic;
    }
}

class EventChannel implements EventChannelInterface
{
    private $topics = [];

    public function publish($topic, $data)
    {
        if (!array_key_exists($topic, $this->topics)) {
            return;
        }

        foreach ($this->topics[$topic] as $subscriber) {
            $subscriber->notify($data);
        }
    }

    public function subscribe($topic, SubscriberInterface $subscriber)
    {
        if (!array_key_exists($topic, $this->topics)) {
            $this->topics[$topic] = [];
        }

        $this->topics[$topic][] = $subscriber;

        echo "<br>" . $subscriber->getName() . " has subscribed on $topic topic";
    }
}

class EventChannelJob
{
    public function run()
    {
        $eventChannel = new EventChannel();

        $bbcNews = new Publisher('bbc-news', $eventChannel);
        $bbcAccident = new Publisher('bbc-accident', $eventChannel);
        $cryptoNews = new Publisher('crypto-news', $eventChannel);

        $andrew = new Subscriber('Andrew');
        $kiryl = new Subscriber('Kiryl');
        $nadya = new Subscriber('Nadya');

        $eventChannel->subscribe('bbc-news', $andrew);
        $eventChannel->subscribe('bbc-news', $kiryl);
        $eventChannel->subscribe('bbc-accident', $nadya);
        $eventChannel->subscribe('crypto-news', $nadya);

        $bbcNews->publish('bbcNews 1');
        $cryptoNews->publish('cryptoNews 1');
        $bbcAccident->publish('bbcAccidentNews 1');
    }
}

$ecj = new EventChannelJob();
$ecj->run();
