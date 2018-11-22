<?php
include_once "Const.php";
/**
 * @description : A Class for Defining constants and Setting Conduction Mode
 * @author : PickleCode
 * @apiNote : DO NOT MODIFY THE CONSTANTS UNLESS YOU EXACTLY KNOW WHAT YOU ARE DOING
 */
if(!class_exists("Configs")) {

	class Configs{

        var $CONFIG;
        var $CONFIG_MODE;
        var $PF_FILE_PATH;
        var $PF_FILE_DISPLAY_PATH;
        var $PF_FILE_PATH_720;
        var $PF_FILE_PATH_640;
        var $PF_FILE_PATH_480;
        var $PF_FILE_PATH_320;
        var $PF_FILE_PATH_100;
        var $PF_DB_HOST;
        var $PF_DB_NAME;
        var $PF_DB_USER;
        var $PF_DB_PASSWORD;
        var $PF_DB_CHARSET;

        var $PF_URL_PATH_WEB;
        var $PF_URL_PATH_SHARED;

		function __construct(){
        	$this->init();
        }

		function init(){
            /**
             * Variables which can be changed by developers and environments
             * @changeable true
             */
            $this->CONFIG_MODE = CONDUCT_MODE_DEV;
//            $this->CONFIG_MODE = CONDUCT_MODE_TEST;
            $this->CONFIG = array(
                CONDUCT_MODE_DEV => array(
                    /**
                     * File Paths for DEV MODE
                     */
                    URL_PATH => "/uploadFiles",
                    URL_DISPLAY_PATH => PF_DEFAULT,
                    URL_PATH_100 => PF_DEFAULT,
                    URL_PATH_320 => PF_DEFAULT,
                    URL_PATH_480 => PF_DEFAULT,
                    URL_PATH_640 => PF_DEFAULT,
                    URL_PATH_720 => PF_DEFAULT,
                    /**
                     * Database Config for DEV MODE
                     */
                    DATABASE_HOST => "picklecode.co.kr",
                    DATABASE_NAME => "dbp_store",
                    DATABASE_USER => "dbpStore",
                    DATABASE_PASSWORD => "dbpStore9505",
                    DATABASE_CHARSET => "utf8",

                    //TODO modify PATH
                    URL_PATH_WEB => "/web",
                    URL_PATH_SHARED => ""
                ),
                CONDUCT_MODE_TEST => array(
                    /**
                     * File Paths for TEST MODE
                     */
                    URL_PATH => "/uploadFiles",
                    URL_DISPLAY_PATH => PF_DEFAULT,
                    URL_PATH_100 => PF_DEFAULT,
                    URL_PATH_320 => PF_DEFAULT,
                    URL_PATH_480 => PF_DEFAULT,
                    URL_PATH_640 => PF_DEFAULT,
                    URL_PATH_720 => PF_DEFAULT,
                    /**
                     * Database Config for TEST MODE
                     */
                    DATABASE_HOST => "picklecode.co.kr",
                    DATABASE_NAME => "dbp_store",
                    DATABASE_USER => "dbpStore",
                    DATABASE_PASSWORD => "dbpStore9505",
                    DATABASE_CHARSET => "utf8",

                    URL_PATH_WEB => "/AppStore/web",
                    URL_PATH_SHARED => "/AppStore"
                ),
                CONDUCT_MODE_LIVE => array(
                    /**
                     * File Paths for LIVE MODE
                     */
                    URL_PATH => PF_DEFAULT,
                    URL_DISPLAY_PATH => PF_DEFAULT,
                    URL_PATH_100 => PF_DEFAULT,
                    URL_PATH_320 => PF_DEFAULT,
                    URL_PATH_480 => PF_DEFAULT,
                    URL_PATH_640 => PF_DEFAULT,
                    URL_PATH_720 => PF_DEFAULT,
                    /**
                     * Database Config for LIVE MODE
                     */
                    DATABASE_HOST => "picklecode.co.kr",
                    DATABASE_NAME => "dbp_store",
                    DATABASE_USER => "dbpStore",
                    DATABASE_PASSWORD => "dbpStore9505",
                    DATABASE_CHARSET => "utf8",

                    URL_PATH_WEB => "/web",
                    URL_PATH_SHARED => ""
                )
            );

            /**
             * Variables which must not be changed
             * @apiNote DO NOT MODIFY UNLESS YOU EXACTLY KNOW WHAT YOU ARE DOING
             * @description Variables to be used by developers
             */
            $this->PF_FILE_PATH = $this->CONFIG[$this->CONFIG_MODE][URL_PATH];
            $this->PF_FILE_DISPLAY_PATH = $this->CONFIG[$this->CONFIG_MODE][URL_DISPLAY_PATH];
            $this->PF_FILE_PATH_720 = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_720];
            $this->PF_FILE_PATH_640 = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_640];
            $this->PF_FILE_PATH_480 = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_480];
            $this->PF_FILE_PATH_320 = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_320];
            $this->PF_FILE_PATH_100 = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_100];
            $this->PF_DB_HOST = $this->CONFIG[$this->CONFIG_MODE][DATABASE_HOST];
            $this->PF_DB_NAME = $this->CONFIG[$this->CONFIG_MODE][DATABASE_NAME];
            $this->PF_DB_USER = $this->CONFIG[$this->CONFIG_MODE][DATABASE_USER];
            $this->PF_DB_PASSWORD = $this->CONFIG[$this->CONFIG_MODE][DATABASE_PASSWORD];
            $this->PF_DB_CHARSET = $this->CONFIG[$this->CONFIG_MODE][DATABASE_CHARSET];
            $this->PF_URL_PATH_WEB = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_WEB];
            $this->PF_URL_PATH_SHARED = $this->CONFIG[$this->CONFIG_MODE][URL_PATH_SHARED];
		}
	}
}

?>
