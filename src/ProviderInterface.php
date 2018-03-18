<?php

namespace Previewtechs\SMSGateway;


use Http\Client\HttpClient;
use InvalidArgumentException;
use Previewtechs\SMSGateway\SMS\Message;

interface ProviderInterface
{
    /**
     * @param HttpClient $httpClient
     *
     * @return ProviderInterface
     */
    public function setHttpClient(HttpClient $httpClient);

    /**
     * @return HttpClient
     */
    public function getHttpClient();

    /**
     * @param Message[] $messages
     *
     * @throws InvalidArgumentException
     *
     * @return Response
     * @throws \Exception
     */
    public function send($messages);
}