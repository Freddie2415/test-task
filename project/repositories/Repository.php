<?php

namespace Project\Repositories;

use Exception;
use mysqli;

abstract class Repository
{
    /**
     * @var false|mysqli|null
     */
    protected static $mysqliConnect;


    public function __construct()
    {
        if (!self::$mysqliConnect) {
            self::$mysqliConnect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_query(self::$mysqliConnect, "SET NAMES 'utf8'");
        }
    }

    /**
     * @param string $query
     * @return bool
     * @throws Exception
     */
    protected function execute(string $query): bool
    {
        if (mysqli_query(self::$mysqliConnect, $query)) {
            return true;
        } else {
            throw new Exception(mysqli_error(self::$mysqliConnect));
        }
    }
}