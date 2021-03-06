<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 07.05.2018
 * Time: 12:43
 */

namespace config;

class Config
{
    protected static $iniFile = "config/config.env";
    protected static $config = [];

    public static function init()
    {
        if (file_exists(self::$iniFile)) {
            $data = parse_ini_file(self::$iniFile, true);
            $databaseConfig = $data["database"];
            self::$config["pdo"]["dsn"] = $databaseConfig ["driver"] . ":host=" . $databaseConfig ["host"] . ";port=" . $databaseConfig["port"] . "; dbname=" . $databaseConfig ["database"] . "; sslmode=require";
            self::$config["pdo"]["user"] = $databaseConfig["user"];
            self::$config["pdo"]["password"] = $databaseConfig["password"];
            self::$config["email"]["sendgrid-apikey"] = $data["email"]["sendgrid-apikey"];
            self::$config["pdf"]["hypdf-user"] = $data["pdf"]["hypdf-user"];
            self::$config["pdf"]["hypdf-password"] = $data["pdf"]["hypdf-password"];
            self::$config["s3"]["key"] = $data["s3"]["key"];
            self::$config["s3"]["secret"] = $data["s3"]["secret"];
            self::$config["s3"]["name"] = $data["s3"]["name"];
        } else {
            if (isset($_ENV["DATABASE_URL"])) {
                $dbopts = parse_url(getenv('DATABASE_URL'));
                self::$config["pdo"]["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"], '/') . "; sslmode=require";
                self::$config["pdo"]["user"] = $dbopts["user"];
                self::$config["pdo"]["password"] = $dbopts["pass"];
            }
            if (isset($_ENV["SENDGRID_APIKEY"])) {
                self::$config["email"]["sendgrid-apikey"] = getenv('SENDGRID_APIKEY');
            }
            if (isset($_ENV["HYPDF_USER"])) {
                self::$config["pdf"]["hypdf-user"] = getenv('HYPDF_USER');
            }
            if (isset($_ENV["HYPDF_PASSWORD"])) {
                self::$config["pdf"]["hypdf-password"] = getenv('HYPDF_PASSWORD');
            }
            if (isset($_ENV["S3_KEY"])) {
                self::$config["s3"]["key"] = getenv('S3_KEY');
            }
            if (isset($_ENV["S3_SECRET"])) {
                self::$config["s3"]["secret"] = getenv('S3_SECRET');
            }
            if (isset($_ENV["S3_NAME"])) {
                self::$config["s3"]["name"] = getenv('S3_NAME');
            }
        }
    }


    public static function pdoConfig($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config["pdo"][$key];
    }

    public static function emailConfig($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config["email"][$key];
    }

    public static function pdfConfig($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config["pdf"][$key];
    }

    public static function s3Config($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config["s3"][$key];
    }
}