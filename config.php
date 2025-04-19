<?php
require_once __DIR__ . '/vendor/autoload.php';

class EnvReader{

    private $path;

    public function __construct($path){
        $this->path = $path;
    }

    private function removeHiddenChars($str){
        $out = "";
        for($i=0; $i < strlen($str);$i++){
            $char = $str[$i];
            // check ascii number of char
            if(ord($char) != 0){
                $out .= $char;
            }
        }
        return $out;
    }


    function read(): array
    {
        $out = array();
        $envX = file_get_contents($this->path);
        $lines = explode("\n",$envX);

        foreach($lines as $line){
            preg_match("/([^#]+)\=(.*)/",$line,$matches);
            if(isset($matches[2])){
                putenv(trim($line));
                [$key, $value] = [...explode("=", $line, 2), null];
                $out[$this->removeHiddenChars($key)] = $value;
            }
        } 

        return $out;    
    }

}

$envReader = new EnvReader(__DIR__."./.env");

$myEnv = $envReader->read();

// Đọc giá trị từ biến môi trường
define("OPENAI_API_KEY", $myEnv['OPEN_API_KEY']);
define("DB_HOST", $myEnv['DB_HOST']);
define("DB_NAME", $myEnv['DB_NAME']);
define("DB_USER", $myEnv['DB_USER']);
define("DB_PASS", $myEnv['DB_PASS']);

// Kiểm tra giá trị đã lấy được
// echo OPENAI_API_KEY;  // In ra API Key đã lấy từ .env
// echo DB_HOST;         // In ra DB Host