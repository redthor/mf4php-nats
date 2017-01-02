<?php

namespace mf4php\nats;

use lf4php\LoggerFactory;
use mf4php\DelayableMessage;
use mf4php\Message;
use mf4php\MessageException;
use mf4php\PriorityableMessage;
use mf4php\Queue;
use mf4php\RuntimeLimitableMessage;
use mf4php\AbstractMessageDispatcher;
use Nats\Connection as NatsConnection;

/**
 * Class: NatsMessageDispatcher
 *
 * @see AbstractMessageDispatcher
 */
class NatsMessageDispatcher extends AbstractMessageDispatcher
{
    /**
     * @var NatsConnection
     */
    private $natsConnection;

    /**
     *
     * @param NatsConnection $natsConnection
     */
    public function __construct(NatsConnection $natsConnection)
    {
        $this->natsConnection = $natsConnection;
    }

    /**
     * @return NatsConnection
     */
    public function getNatsConnection()
    {
        return $this->natsConnection;
    }

    /**
     * @param Queue $queue
     * @param Message $message
     */
    public function send(Queue $queue, Message $message)
    {
        $logger = LoggerFactory::getLogger(__CLASS__);
        try {
            $serializedMessage = serialize($message);
            if (!$this->natsConnection->isConnected()) {
                $this->natsConnection->connect();
            }
            $this->natsConnection->publish($queue->getName(), $serializedMessage);
            $logger->info(
                'A message has been published with nats subject [{}], published count is [{}]',
                [$queue->getName(), $this->natsConnection->pubsCount()]
            );
            $logger->debug('Nats message is: [{}]', [$serializedMessage]);
        } catch (\Exception $e) {
            $newExp = new MessageException('Message sending error!', null, $e);
            $logger->error($newExp);
            throw $newExp;
        }
    }
}
