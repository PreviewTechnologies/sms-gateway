<?php

namespace Previewtechs\SMSGateway;

class Client
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array $messages
     *
     * @return Response
     * @throws \Exception
     */
    public function send(array $messages)
    {
        return $this->provider->send($messages);
    }
}