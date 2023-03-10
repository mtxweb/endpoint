<?php
require_once('curl.class.php');

class curlTest extends cUrlRequest
{
    public function onError()
    {
        echo "Errore nelle richiesta. Codice di errore: " . $this->code;
    }

    public function onSuccess()
    {
        echo $this->response;
    }
}

$args = array(  'url' => 'https://mtxweb.internet-box.ch/endpoint/test/',
                'auth' => true,
                'username' => 'endpoint',
                'password' => 'Q12vg6**L?!mtxweb2023'
            );
$req = new curlTest($args);

$send = array(  'type' => 'test',
                'val1' => 'value1',
                'val2' => true,
                'val3' => 150);

$req->simpleCall('', $send);
?>