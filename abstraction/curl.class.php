<?php
abstract class cUrlRequest 
{
    protected $ch;
    public $code;
    public $opt;
    public $abort;
    public $response;
    
        public function __construct($options = array())
        {
            $defaults = array(  'url' => '',
                                'auth' => false,
                                'username' => '',
							  	'password' => '',
                                'timeout' => 30,
                                'headers' => array(),
                                'verify-host' => 0,
                                'verify-peer' => 0,
                                'return-transfer' => true
                                );
                                
            $this->opt = array_merge((array)$defaults,(array)$options);

            //$this->headers[] = 'Content-Type: multipart/form-data';
            //$this->username = 'endpoint';
            //$this->password = 'Q12vg6**L?!mtxweb2023';
            //$this->url = 'https://94-237-85-227.de-fra1.upcloud.host/endpoint/mp3/';
            //$this->code = '';
        }
        
        protected function init_curl_connection($str)
        {
            $this->ch = curl_init($this->opt['url'] . $str);
            if($this->opt['headers'])
            {
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->opt['headers']);
            }
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->opt['return-transfer']);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, $this->opt['verify-host']);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $this->opt['verify-peer']);
            curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->opt['timeout']);
            if($this->opt['auth'])
            {
                $user = $this->opt['username'];
                $password = $this->opt['password'];
                curl_setopt($this->ch, CURLOPT_USERPWD, "$user:$password");
                curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            }
            
        }

        public function simpleCall($str, $args = array())
        {
            $this->init_curl_connection($str);
            if($args)
            {
                curl_setopt($this->ch, CURLOPT_POST, 1);
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, $args);
            }
            
            $this->response = curl_exec($this->ch);
            $this->processResult();
        }

        public function downloadFile($file, $downloadLocation, $filename = '')
        {
            if(!$filename)
            {
                $filename = $file;
            }
            $this->opt['headers'][] = 'Content-Type: multipart/form-data';
            $this->init_curl_connection($file);
            $fh = fopen($downloadLocation . $filename, "w");
            curl_setopt($this->ch, CURLOPT_FILE, $fh);
            $this->response = curl_exec($this->ch);
            (int)$this->code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            fclose($fh);
            $this->processResult();
        }

        protected function processResult()
        {
            (int)$this->code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            if($this->code > 299)
            {
                $this->abort = true;
                curl_close($this->ch);
                $this->onError();
            }
            else
            {
                $this->abort = false;
                curl_close($this->ch);
                $this->onSuccess();
            }
        }

        public abstract function onError();
        public abstract function onSuccess();
}

?>