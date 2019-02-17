<?php

namespace Parsidev\MeliPayamak;

use SoapClient;

class MeliPayamak
{
    protected $confg;
    protected $client;

    public function __construct($config)
    {
        $this->confg = $config;
    }

    private function responseGenerator($response)
    {
        $result = [];
        $result['status'] = intval($response->string);

        switch ($result['status']) {
            case 0:
                $result['message'] = "نام کاربری یا رمز عبور اشتباه می‌باشد.";
                break;
            case 1:
                $result['message'] = "درخواست با موفقیت انجام شد.";
                break;
            case 2:
                $result['message'] = "اعتبار، کافی نمی‌باشد.";
                break;
            case 3:
                $result['message'] = "محدودیت در ارسال روزانه";
                break;
            case 4:
                $result['message'] = "محدودیت در حجم ارسال";
                break;
            case 5:
                $result['message'] = "شماره فرستنده معتبر نمی‌باشد.";
                break;
            case 6:
                $result['message'] = "سامانه در حال بروزرسانی می‌باشد.";
                break;
            case 7:
                $result['message'] = "متن حاوی کلمه فیلتر شده می‌باشد.";
                break;
            case 9:
                $result['message'] = "ارسال از خطوط عمومی از طریق وب سرویس امکان‌پذیر نمی‌باشد.";
                break;
            case 10:
                $result['message'] = "کاربر مورد نظر فعال نمی‌باشد.";
                break;
            case 11:
                $result['message'] = "ارسال نشده";
                break;
            case 12:
                $result['message'] = "مدارک کاربر کامل نمی‌باشد.";
                break;
            default:
                $result['message'] = "پیامک با موفقیت ارسال شد.";
                break;
        }
        return $result;
    }

    //Connect Start
    public function connectForSend()
    {
        $this->client = new SoapClient($this->confg['SendUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForContact()
    {
        $this->client = new SoapClient($this->confg['ContactUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForReceive()
    {
        $this->client = new SoapClient($this->confg['ReceiveUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForTicket()
    {
        $this->client = new SoapClient($this->confg['TicketUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForUser()
    {
        $this->client = new SoapClient($this->confg['UserUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForSchedule()
    {
        $this->client = new SoapClient($this->confg['ScheduleUrl'], ['encoding' => 'UTF-8']);
    }

    public function connectForRegional()
    {
        $this->client = new SoapClient($this->confg['RegionalUrl'], ['encoding' => 'UTF-8']);
    }
    //Connect End
    //Send Start
    public function getStatuses($uniqueId)
    {
        $this->connectForSend();
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
        $this->connectForSend();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['recId'] = $uniqueId;
        $response = $this->client->GetDelivery2($parameters)->GetDeliveryResult;
        return $response;
    }

    public function sendSMS($to, $message, $from = null, $type = 'normal')
    {
        $this->connectForSend();
        if (!is_array($to))
            $to = [$to];
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['to'] = $to;

        if (is_null($from))
            $parameters['from'] = $this->confg['fromNumber'];
        else
            $parameters['from'] = $from;

        $parameters['text'] = $message;

        $parameters['isflash'] = $type == 'flash';

        $response = $this->client->SendSimpleSMS($parameters)->SendSimpleSMSResult;
        return $this->responseGenerator($response);
    }

    public function getCredit()
    {
        $this->connectForSend();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $response = $this->client->GetCredit($parameters)->GetCreditResult;
        return $response;
    }
    //Send End
    //Contact Start
    public function addGroup($groupName, $description, $showToChilds)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['groupName'] = $groupName;
        $parameters['Descriptions'] = $description;
        $parameters['showToChilds'] = $showToChilds;
        $response = $this->client->AddGroup($parameters)->AddGroupResult;
        return $response;
    }

    public function addContact($groupId, $firstName, $lastName, $nickName, $corporation, $cellPhone, $phone, $fax,
                               $birthDate, $email, $gender, $province, $city, $address, $postalCode, $additionDate,
                               $additionText, $descriptions)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['groupIds'] = $groupId;
        $parameters['firstname'] = $firstName;
        $parameters['lastname'] = $lastName;
        $parameters['nickname'] = $nickName;
        $parameters['corporation'] = $corporation;
        $parameters['mobilenumber'] = $cellPhone;
        $parameters['phone'] = $phone;
        $parameters['fax'] = $fax;
        $parameters['birthdate'] = $birthDate;
        $parameters['email'] = $email;
        $parameters['gender'] = $gender;
        $parameters['province'] = $province;
        $parameters['city'] = $city;
        $parameters['address'] = $address;
        $parameters['postalCode'] = $postalCode;
        $parameters['additionaldate'] = $additionDate;
        $parameters['additionaltext'] = $additionText;
        $parameters['descriptions'] = $descriptions;
        $response = $this->client->AddContact($parameters)->AddContactResult;
        return $response;
    }

    public function checkMobileExistInContact($mobileNumber)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['mobileNumber'] = $mobileNumber;
        $response = $this->client->CheckMobileExistInContact($parameters)->CheckMobileExistInContactResult;
        return $response;
    }

    public function getContacts($groupId, $keyword, $from, $count)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['groupId'] = $groupId;
        $parameters['keyword'] = $keyword;
        $parameters['from'] = $from;
        $parameters['count'] = $count;
        $response = $this->client->GetContacts($parameters)->GetContactsResult;
        return $response;
    }

    public function getGroups()
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $response = $this->client->GetGroups($parameters)->GetGroupsResult;
        return $response;
    }

    public function changeContact($contactId, $mobileNumber, $firstName, $lastName, $nickName, $corporation, $phone,
                                  $fax, $email, $gender, $province, $city, $address, $postalCode, $additionText,
                                  $descriptions, $contactState)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['contactId'] = $contactId;
        $parameters['firstname'] = $firstName;
        $parameters['lastname'] = $lastName;
        $parameters['nickname'] = $nickName;
        $parameters['corporation'] = $corporation;
        $parameters['mobilenumber'] = $mobileNumber;
        $parameters['phone'] = $phone;
        $parameters['fax'] = $fax;
        $parameters['email'] = $email;
        $parameters['gender'] = $gender;
        $parameters['province'] = $province;
        $parameters['city'] = $city;
        $parameters['address'] = $address;
        $parameters['postalCode'] = $postalCode;
        $parameters['additionaltext'] = $additionText;
        $parameters['descriptions'] = $descriptions;
        $parameters['contactStatus'] = $contactState;
        $response = $this->client->ChangeContact($parameters)->ChangeContactResult;
        return $response;
    }

    public function removeContact($mobileNumber)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['mobilenumber'] = $mobileNumber;
        $response = $this->client->RemoveContact($parameters)->RemoveContactResult;
        return $response;
    }

    public function getContactEvents($contactId)
    {
        $this->connectForContact();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['contactId'] = $contactId;
        $response = $this->client->GetContactEvents($parameters)->GetContactEventsResult;
        return $response;
    }
    //Contact End
    //Receive Start
    public function getInboxCount($isRead)
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['isRead'] = $isRead;
        $response = $this->client->GetInboxCount($parameters)->GetInboxCountResult;
        return $response;
    }

    public function getOutBoxCount()
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $response = $this->client->GetOutBoxCount($parameters)->GetOutBoxCountResult;
        return $response;
    }

    public function getMessages($location, $from, $index, $count)
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['location'] = $location;
        $parameters['from'] = $from;
        $parameters['index'] = $index;
        $parameters['count'] = $count;
        $response = $this->client->GetMessages($parameters)->GetMessagesResult;
        return $response;
    }

    public function getMessagesStr($location, $from, $index, $count)
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['location'] = $location;
        $parameters['from'] = $from;
        $parameters['index'] = $index;
        $parameters['count'] = $count;
        $response = $this->client->GetMessageStr($parameters)->GetMessageStrResult;
        return $response;
    }

    public function getMessageByDate($location, $from, $index, $count, $dateFrom, $dateTo)
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['location'] = $location;
        $parameters['from'] = $from;
        $parameters['index'] = $index;
        $parameters['count'] = $count;
        $parameters['dateFrom'] = $dateFrom;
        $parameters['dateTo'] = $dateTo;
        $response = $this->client->GetMessagesByDate($parameters)->GetMessagesByDateResult;
        return $response;
    }

    public function removeMessage($messageId)
    {
        $this->connectForReceive();
        $parameters['username'] = $this->confg['Username'];
        $parameters['password'] = $this->confg['Password'];
        $parameters['msgIds'] = $messageId;
        $response = $this->client->RemoveMessages($parameters)->RemoveMessagesResult;
        return $response;
    }
    //Receive End
}
