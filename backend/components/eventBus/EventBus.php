<?php

namespace app\components\eventBus;

use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\base\Component;

class EventBus extends Component implements ConsumerInterface
{
    private $eventsHandlers = [
        EventName::PRODUCT_PARSED => [

        ]
    ];

    public function execute(AMQPMessage $msg)
    {
        try {
            $key = $msg->getRoutingKey();
            $eventName = substr(
                $key,
                strpos(
                    $key,
                    '.'
                ) + 1
            );

            return ConsumerInterface::MSG_ACK;
        } catch (\Exception $e) {
            return ConsumerInterface::MSG_REQUEUE;
        }
    }

    public function publishEvent(string $eventName, array $data): void
    {
        $producer = Yii::$app->rabbitmq->getProducer('events-producer');
        $producer->publish($data, 'all-events', "router.$eventName");
    }

    public function handleEvent():void
    {

    }
}