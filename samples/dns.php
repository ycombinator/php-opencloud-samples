<?php

require '../vendor/autoload.php';

use OpenCloud\Rackspace;

//$s is getting a settings file with the keys.
//The username and apikey for this object look correct and the value for the UK url is "https://lon.identity.api.rackspacecloud.com/v2.0/".
$rackspace = new Rackspace(Rackspace::UK_IDENTITY_ENDPOINT, array(
    'username' => 'ycombinator',
    'apiKey' => '86547762835f10946b788fdd0a8ed6a6'
));

//It is failing on the following line.
$dns = $rackspace->dnsService();
