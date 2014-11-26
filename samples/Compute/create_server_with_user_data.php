<?php

/*
 * Copyright 2014 Rackspace US, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Pre-requisites:
 *
 * Prior to running this script, you must setup the following environment variables:
 * - RAX_USERNAME: Your Rackspace Cloud Account Username, and
 * - RAX_API_KEY:  Your Rackspace Cloud Account API Key, and
 * - RAX_IMAGE_ID: The ID of the image you want to use for creating this server
 */

require __DIR__ . '/../../vendor/autoload.php';

use OpenCloud\Rackspace;
use Guzzle\Http\Exception\BadResponseException;

// 1. Instantiate a Rackspace client.
$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
    'username' => getenv('RAX_USERNAME'),
    'apiKey'   => getenv('RAX_API_KEY')
));

// 2. Create Compute service
$region = 'DFW';
$service = $client->computeService(null, $region);

// 3. Get empty server
$server = $service->server();

// 4. Select a hardware flavor
$flavors = $service->flavorList();
foreach ($flavors as $flavor) {
    if (strpos($flavor->name, '2GB') !== false) {
        $twoGbFlavor = $flavor;
        break;
    }
}

// 5. Create server
try {
    $response = $server->create(array(
        'name'     => 'My custom server',
        'imageId'  => getenv('RAX_IMAGE_ID'),
        'flavor'   => $twoGbFlavor,
        'user_data' => base64_encode(file_get_contents('user_data.yml'))
    ));
} catch (BadResponseException $e) {
    // No! Something failed. Let's find out:
    echo $e->getResponse();
}
