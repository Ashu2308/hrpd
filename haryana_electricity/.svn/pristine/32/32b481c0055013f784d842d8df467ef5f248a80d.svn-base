<?php

class ErrorManager
{

    public static function error_log($e)
    {
        $dt = date('Y-m-d H:i:s', time());
        error_log("[{$dt}] " . $e->getMessage() . PHP_EOL, 3, "errors.log");
    }
}

?>