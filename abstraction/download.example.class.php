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
        echo "file scaricato";
    }
}

$args = array(  'url' => 'https://mtxweb.internet-box.ch/endpoint/test/download/',
                'auth' => true,
                'username' => 'endpoint',
                'password' => 'Q12vg6**L?!mtxweb2023'
            );
$req = new curlTest($args);


$req->downloadFile('test.mp3', dirname(__FILE__) . '/tmp//');
?>