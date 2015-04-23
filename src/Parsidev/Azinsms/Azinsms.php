<?php

namespace Parsidev\Azinsms;

class Azinsms {

    protected $confg;
    protected $client;

    public function __construct($config, $client) {
        $this->confg = $config;
        $this->client = $client;
    }

    public function getCredit() {
        $response = $this->client->GetCredit(
                array(
                    'Username' => $this->confg['Username'],
                    'Password' => $this->confg['Password']
                )
        );
        
        return $response;
    }

}
