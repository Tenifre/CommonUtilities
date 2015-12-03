<?php
  /**
   * ユーティリティ
   *
   * @Author YuArai
   * @Ver 1.0
   */

class TFUtility {

  /**
   * 指定した文字列で始まるかどうか
   *
   * @param {String} $haystack
   * @param {String} $needle
   * @return {Boolean}
   */
  public static function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
  }

  /**
   * 指定した文字列で終わるかどうか
   *
   * @param {String} $haystack
   * @param {String} $needle
   * @return {Boolean}
   */
  public static function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
  }

  /** 
   * ランダムな文字列を生成
   *
   * @param   {Integer} $length
   * @return  {String}
   */
  public static function generateRandomStr($length=8)
  {   
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
    $str = ''; 
    for ($i = 0; $i < $length; $i++) {
      $str .= $chars[mt_rand(0, 61)];
    }   
    return $str;
  }

  /** 
   * 文字列の文字コードを取得
   *
   * @param {String} $str
   * @param {String} $encoding
   * @return {String}
   */
  public static function getEncoding($str, $encoding='auto') {
    $encode_list = array('UTF-8', 'EUC-JP', 'SJIS');
    if(is_array($str)){
      $tmp = $str;
      foreach($encode_list as $list){
        $str  = $tmp;
        mb_convert_variables($list,$list,$str);
        if($str==$tmp){
          $encoding = $list;
          break;
        }
      }
    }else {
      foreach($encode_list as $list){
        if($str==mb_convert_encoding($str,$list,$list)){
          $encoding = $list;
          break;
        }
      }
    }

    return $encoding;
  }

  /**
   * 配列をCSV形式で保存
   *
   * @param {Array} $arr
   * @param {String} $path
   * @return {Boolean}
   */
  public static function arrayToCsv($arr, $path) {
    $fp = fopen("php://temp", "r+b");
    foreach ($arr as $key => $fields) {
      fputcsv($fp, $fields);
    }
    rewind($fp);
    $tmp = str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));

    $ret = file_put_contents($path, $tmp);
    return $ret;
  }
}
