<?php
chdir(__DIR__);
include_once "../bases/Configs.php";

class innerRoute extends Configs{
    function __construct(){
        parent::__construct();
//        echo $_SERVER["DOCUMENT_ROOT"] . $this->PF_URL_PATH_SHARED . "/shared/public";
        chdir($_SERVER["DOCUMENT_ROOT"] . $this->PF_URL_PATH_SHARED . "/shared/public");
        foreach (glob("classes/*.php") as $filename) {
//            echo $filename;
            include_once $filename;
        }
    }
}

