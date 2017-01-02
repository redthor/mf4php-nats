<?php
namespace mf4php\nats;

use PHPUnit_Framework_TestCase;

require_once 'SampleObject.php';

class NatsMessageTest extends PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $obj = new SampleObject('test@host.com');
        $message = new NatsMessage($obj);
        self::assertInstanceOf('\DateTime', $message->getDateTime());
    }

    public function testSerialize()
    {
        $obj = new SampleObject('test@host.com');
        $message = new NatsMessage($obj);

        $serialized = serialize($message);
        $deserMsg = unserialize($serialized);

        self::assertEquals($message->getDateTime(), $deserMsg->getDateTime());
        self::assertEquals($message->getObject()->getEmail(), $deserMsg->getObject()->getEmail());
    }
}
