<?php
/**
 * Created by PhpStorm.
 * User: ma.rayan
 * Date: 12/1/2018
 * Time: 8:08 AM
 */


namespace App\Constants;

class StatusCodes {
    const OK = 200;
    const NOT_FOUND = 404;
    const INTERNAL_ERROR = 500;
    const FORBIDDEN = 403;

    const NONE = 0x00000000;
    const ERROR = 0x00000000;
    const SUCCESS = 0x00000001;
    const SHOW_MESSAGE = 0x00000002; //2
    const HIDE_MESSAGE = 0x00000004; //4
    const UPDATE_APP = 0x00000006; //6
    const FORM = 0x00000008; //8
    const ACCESS_TOKEN_MISSING = 0x00000010; // 16
    const ACCESS_TOKEN_INVALID = 0x00000020; // 32
    const USER_DEACTIVATED = 0x00000040; // 64

    /*
     * Combination
     */
    public static function ERROR_WITH_SHOW_MESSAGE() {
        return self::ERROR | self::SHOW_MESSAGE;
    }
}

