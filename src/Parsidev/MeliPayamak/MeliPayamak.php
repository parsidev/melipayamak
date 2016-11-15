<?php

namespace Parsidev\MeliPayamak;

class MeliPayamak
{

    protected $confg;
    protected $client;

    public function __construct($config, $client)
    {
        $this->confg = $config;
        $this->client = $client;
    }

    public function getStatuses($uniqueId)
    {
        if (!is_array($uniqueId))
            $uniqueId = [$uniqueId];
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['recIds'] = $uniqueId;
        $response = $this->client->GetDeliveries($parameters)->GetDeliveriesResult;
        return $response;
    }

    public function getStatus($uniqueId)
    {
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['recId'] = $uniqueId;
        $response = $this->client->GetDelivery2($parameters)->GetDeliveryResult;
        return $response;
    }

    public function sendSMS($to, $message, $type = 'normal')
    {
        if (!is_array($to))
            $to = [$to];
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['to'] = $to;
        $parameters['from'] = $this->confg['fromNumber'];
        $parameters['text'] = $message;
        if ($type == 'normal')
            $parameters['isflash'] = false;
        elseif ($type == 'flash')
            $parameters['isflash'] = true;

        $response = $this->client->SendSimpleSMS($parameters)->SendSimpleSMSResult;

        foreach ($response as $v) {
            $response = $v;
        }

        return $response;
    }

    public function getCredit()
    {
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $response = $this->client->GetCredit($parameters)->GetCreditResult;

        return $response;
    }

}
