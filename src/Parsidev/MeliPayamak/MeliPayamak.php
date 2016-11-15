<?php

namespace Parsidev\MeliPayamak;

class MeliPayamak {

    protected $confg;
    protected $client;

    public function __construct($config, $client) {
        $this->confg = $config;
        $this->client = $client;
    }

    public static function CorrectNumber(&$uNumber) {
        $uNumber = Trim($uNumber);
        $ret = &$uNumber;

        if (substr($uNumber, 0, 3) == '%2B') {
            $ret = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 3) == '%2b') {
            $ret = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 4) == '0098') {
            $ret = substr($uNumber, 4);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 3) == '098') {
            $ret = substr($uNumber, 3);
            $uNumber = $ret;
        }


        if (substr($uNumber, 0, 3) == '+98') {
            $ret = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 2) == '98') {
            $ret = substr($uNumber, 2);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 1) == '0') {
            $ret = substr($uNumber, 1);
            $uNumber = $ret;
        }

        return '+98' . $ret;
    }

    public function getStatus($uniqueId) {
        $userName = $this->confg['Username'];
        $password = $this->confg['Password'];
        if (is_array($uniqueId)) {
            $i = sizeOf($uniqueId);

            while ($i--) {
                $uniqueId[$i] = $uniqueId[$i];
            }
        } else {
            $uniqueId = array($uniqueId);
        }

        $response = $this->client->GetStatus(
                $userName, $password, $uniqueId
        );

        return $response;
    }

    public function sendSMS($to, $message, $type = 'normal') {
        $userName = $this->confg['Username'];
        $password = $this->confg['Password'];
        $fromNum = $this->confg['fromNumber'];
        if (is_array($to)) {
            $i = sizeOf($to);

            while ($i--) {
                $to[$i] = $this->CorrectNumber($to[$i]);
            }
        } else {
            $to = array($this->CorrectNumber($to));
        }
        $response = $this->client->SendSMS(
                $fromNum, $to, $message, $type, $userName, $password
        );

        return $response;
    }

    public function getCredit() {
        $response = $this->client->GetCredit(
                $this->confg['Username'], $this->confg['Password']
        );

        return $response;
    }

}
