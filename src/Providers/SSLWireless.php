<?php

namespace Previewtechs\SMSGateway\Providers;


use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;
use Http\Client\HttpClient;
use InvalidArgumentException;
use Previewtechs\SMSGateway\ProviderInterface;
use Previewtechs\SMSGateway\Response;
use Previewtechs\SMSGateway\SMS\Message;
use Psr\Http\Message\ResponseInterface;

class SSLWireless implements ProviderInterface
{
    protected $apiEndpoint = 'http://sms.sslwireless.com/pushapi/dynamic/server.php';

    protected $httpClient;
    protected $userName;
    protected $password;
    protected $sid;

    public function __construct($userName, $password, $sid)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->sid = $sid;

        $httpClientConfig = ['timeout' => 10];
        $this->httpClient = Client::createWithConfig($httpClientConfig);
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return ProviderInterface
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param Message[] $messages
     *
     * @throws InvalidArgumentException
     *
     * @return Response
     * @throws \Exception
     */
    public function send($messages)
    {
        if (!is_array($messages)) {
            throw new InvalidArgumentException("Message parameter must be an array");
        }

        foreach ($messages as $message) {
            if (!$message instanceof Message) {
                throw new InvalidArgumentException("Message must be an instance of Previewtechs\SSLCommerce\SMSGateway\SMS\Message() class");
            }
        }

        $postBody = ['user' => $this->userName, 'pass' => $this->password, 'sid' => $this->sid];

        foreach ($messages as $message) {

            if ($message->isConvertToUnicode() === true) {
                $processedMessage = $this->convertToUnicode($message->getMessage());
            } else {
                $processedMessage = $message->getMessage();
            }

            $postBody['sms'][] = [$message->getRecipient(), $processedMessage, rand(111, 33333)];
        }

        $request = new Request("POST", $this->apiEndpoint, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ], http_build_query($postBody));

        $response = $this->httpClient->sendRequest($request);
        return $this->buildResponse($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return Response
     * @throws \Exception
     */
    protected function buildResponse(ResponseInterface $response)
    {
        $xml = simplexml_load_string($response->getBody());
        $json = json_encode($xml);
        $array = json_decode($json, true);

        $res = new Response();

        if ($array['PARAMETER'] != "OK") {
            throw new \Exception("Failed to process the API request. Response: " . $array['PARAMETER']);
        }

        if ($array['LOGIN'] != "OK") {
            throw new \Exception("API Autentication failed!");
        }

        if ($array['PARAMETER'] === "OK" && $array['LOGIN'] === "SUCCESSFULL") {
            $res->setSuccess(true);
        }

        if (!empty($array['SMSINFO'])) {
            $smsInfo = [];
            if (array_key_exists(0, $array['SMSINFO']) === false) {
                $m = new Message();
                $m->setRecipient($array['SMSINFO']['MSISDN']);
                $m->setMessage($array['SMSINFO']['SMSTEXT']);
                $m->setClientIdentifier($array['SMSINFO']['CSMSID']);
                $m->setGatewayReferenceId($array['SMSINFO']['REFERENCEID']);

                $smsInfo[] = $m;
            } else {
                foreach ($array['SMSINFO'] as $sms) {
                    $m = new Message();
                    $m->setRecipient($sms['MSISDN']);
                    $m->setMessage($sms['SMSTEXT']);
                    $m->setClientIdentifier($sms['CSMSID']);
                    $m->setGatewayReferenceId($sms['REFERENCEID']);

                    $smsInfo[] = $m;
                }
            }

            $res->setMessages($smsInfo);
            $res->setResponseRaw((string)$response->getBody());
        }

        return $res;
    }

    /**
     * @param $sring
     *
     * @return string
     */
    protected function convertToUnicode($sring)
    {
        return strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $sring)));
    }
}