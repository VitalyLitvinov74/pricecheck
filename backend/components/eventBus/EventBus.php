<?php

namespace app\components\eventBus;

use app\modules\Product\application\Product\EventHandlers\ProductParsedHandler;
use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\base\Component;

class EventBus extends Component implements ConsumerInterface
{
    private $eventsHandlers = [
        EventName::ProductParsedFromFile => [
            ProductParsedHandler::class
        ]
    ];

    public function execute(AMQPMessage $msg)
    {
        try {
            $key = $msg->getRoutingKey();
            $eventName = $this->eventNameFrom($key);

            foreach ($this->eventsHandlers[$eventName] as $handlerClass) {
                $handler = Yii::createObject($handlerClass);
                /** @var object $handler */
                $handler->__invoke($eventName, $msg->getBody());
            }
            return ConsumerInterface::MSG_ACK;
        } catch (\Exception $e) {
            return ConsumerInterface::MSG_REQUEUE;
        }
    }

    public function publishEvent(string $eventName, array $data): void
    {
        $producer = Yii::$app->rabbitmq->getProducer('events-producer');
        $producer->publish($data, 'all-events', "events.$eventName");
    }

    private function eventNameFrom(string $key): string{
        return substr(
            $key,
            strpos(
                $key,
                '.'
            ) + 1
        );
    }
}