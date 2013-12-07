<?php

namespace Martha\Core\Domain\Entity;

use DateTime;

/**
 * Class Error
 * @package Martha\Core\Domain\Entity
 */
class Error extends AbstractEntity
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var boolean
     */
    protected $wasRead = false;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param boolean $wasRead
     * @return $this
     */
    public function setWasRead($wasRead)
    {
        $this->wasRead = $wasRead;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getWasRead()
    {
        return $this->wasRead;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
