<?php

/**
 * 抽象メソッドクラス
 */
class Common {

    /**
     * 文字列内の禁則文字を除外して返却します
     */
    public static function esc($str) {
    }

    /**
     * IDを指定した桁数まで0埋めして返却します
     * @param $id ID
     * @param $digit 桁数
     */
    public static function countup_id($id, $digit) {
        if ($digit < 0 || $digit <= strlen($id)) {
            return $id;
        }
        return str_pad($id, $digit, '0', STR_PAD_LEFT);
    }

    /**
     * 文字列を指定した文字数まで切り捨てて返却します
     * @param $str 文字列
     * @param $num 文字数
     */
    public static function start_truncate($str, $num) {
        if (empty($str)) return 0;
        if ($num < 0 || strlen($str) <= $num) return 0;
        return mb_substr($str, $num, strlen($str));
    }

    /**
     * 文字列を指定した文字数以降の文字を切り捨てて返却します
     * @param $str 文字列
     * @param $num 文字数
     */
    public static function end_truncate($str, $num) {
        if ($num < 0 || strlen($str) <= $num) {
            return $str;
        }
        return mb_substr($str, 0, $num);
    }

    /**
     * 文字列を指定した文字数まで空白埋めして返却します
     * @param $str 文字列
     * @param $num 文字数
     */
    public static function fill($str, $num) {
        if ($num < 0 || $num <= strlen($str)) {
            return $str;
        }
        return str_pad($str, $num);
    }

    /**
     * 画像からbase64形式にデータを変換して返却します
     * @param $img 画像
     */
    public static function encode($img) {
        return base64_encode($img);
    }

    /**
     * base64形式から画像にデータを変換して返却します
     * @param $str base64形式
     */
    public function decode($str) {
        return base64_decode($str);
    }
}
