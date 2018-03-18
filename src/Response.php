<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SMSGateway;


use Previewtechs\SMSGateway\SMS\Message;

class Response
{
    /**
     * @var int|string|null
     */
    protected $identifier;

    /**
     * @var Message[] $messages
     */
    protected $messages;

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string
     */
    protected $responseRaw;

    /**
     * @return int|null|string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param int|null|string $identifier
     *
     * @return Response
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param Message[] $messages
     *
     * @return Response
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return Response
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseRaw()
    {
        return $this->responseRaw;
    }

    /**
     * @param string $responseRaw
     *
     * @return Response
     */
    public function setResponseRaw($responseRaw)
    {
        $this->responseRaw = $responseRaw;
        return $this;
    }
}