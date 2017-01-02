<?php
namespace mf4php\nats;

use Nats\Connection;
use mf4php\DefaultQueue;
use PHPUnit_Framework_TestCase;

require_once 'SampleObject.php';

class NatsMessageDispatcherTest extends PHPUnit_Framework_TestCase
{
    private $natsConnection;

    /**
     * @var NatsMessageDispatcher
     */
    private $dispatcher;

    public function setUp()
    {
        $this->natsConnection = $this->createMock(Connection::class);
        $this->dispatcher = new NatsMessageDispatcher($this->natsConnection);
    }

    public function testSend()
    {
        $queue = new DefaultQueue('testSubject');
        $obj = $this->createMock('Serializable');
        $message = new NatsMessage($obj);
        $this->natsConnection->method('pubsCount')->willReturn(1);
        $this->dispatcher->send($queue, $message);
        self::assertEquals(1, $this->natsConnection->pubsCount());
    }
}
