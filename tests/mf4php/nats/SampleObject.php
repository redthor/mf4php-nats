<?php

namespace mf4php\nats;

use Serializable;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class SampleObject implements Serializable
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function serialize()
    {
        return serialize($this->email);
    }

    public function unserialize($serialized)
    {
        $this->email = unserialize($serialized);
    }
}
