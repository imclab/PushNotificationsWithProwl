<?php
namespace SitePoint\Log\Writer;
use Zend\Log;

class Prowl extends \Zend\Log\Writer\AbstractWriter
{
    private $apiKeys;
 
    public function __construct($apiKeys) {
        if (is_array($apiKeys)) {
            $this->apiKeys = $apiKeys;
        }
        else {
            $this->apiKeys = array($apiKeys);
        }
 
        $this->_formatter = new Log\Formatter\Simple('%message%');
    }
 
    protected function doWrite(array $event) {
        $event = $this->_formatter->format($event);
 
        $prowl = new \Prowl\Connector();
        $prowl->setFilterCallback(function ($text) {
            return $text;
        });
        $prowl->setIsPostRequest(true);
 
        $msg = new \Prowl\Message();
        $msg->setApplication('My Custom Logger');
        $msg->setPriority(2);
        $msg->setEvent($event);
        foreach ($this->apiKeys as $key) {
            $msg->addApiKey($key);
        }
 
        $prowl->push($msg);
    }
}
