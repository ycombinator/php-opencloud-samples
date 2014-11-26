<?php


        require __DIR__ . '/../vendor/autoload.php';
        $secret = array(
            "username" => "ycombinator",
            "apiKey" => getenv("RAX_API_KEY")
        );
        try {
            $client = new OpenCloud\Rackspace(OpenCloud\Rackspace::US_IDENTITY_ENDPOINT, $secret);
            $compute = $client->computeService(null, "DFW");

            $identity = $client->identityService();

            $user = $identity->createUser(array(
                'username' => "sh@sh.ir",
                'email' => "sh@sh.ir",
                'tenantId' => "abc0ecf183f84540b0e4982607c9772a",
                'password' => '123456',
                'enabled' => true
            ));
        } catch (Exception $exc) {
            //            echo $exc->getResponse();
            echo $exc->getTraceAsString();
            echo PHP_EOL . "----------------------------------------" . PHP_EOL;
            echo $exc->getMessage();
        }
