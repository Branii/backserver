<?php

class Utils 
{

    public static function getTables(int $lotteryId)
    {
        return (new Model())->getTables($lotteryId);
    }

    public static function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

}