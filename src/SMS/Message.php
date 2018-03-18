<?php

namespace Previewtechs\SMSGateway\SMS;


class Message
{
    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $clientIdentifier;

    /**
     * @var int|string
     */
    protected $gatewayReferenceId;

    /**
     * @var bool
     */
    protected $convertToUnicode;

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     *
     * @return Message
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
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
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientIdentifier()
    {
        if (!empty($this->clientIdentifier)) {
            return $this->clientIdentifier;
        }

        return $this->clientIdentifier = crc32(rand(1111111111, 9999999999));
    }

    /**
     * @param int $clientIdentifier
     *
     * @return Message
     */
    public function setClientIdentifier($clientIdentifier)
    {
        $this->clientIdentifier = $clientIdentifier;
        return $this;
    }

    /**
     * @return int|string
     */
    public function getGatewayReferenceId()
    {
        return $this->gatewayReferenceId;
    }

    /**
     * @param int|string $gatewayReferenceId
     *
     * @return Message
     */
    public function setGatewayReferenceId($gatewayReferenceId)
    {
        $this->gatewayReferenceId = $gatewayReferenceId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConvertToUnicode()
    {
        return $this->convertToUnicode;
    }

    /**
     * @param bool $convertToUnicode
     *
     * @return Message
     */
    public function setConvertToUnicode($convertToUnicode = true)
    {
        $this->convertToUnicode = $convertToUnicode;
        return $this;
    }
}