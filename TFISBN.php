<?php
/**
 * ISBN の 10桁 / 13桁変換
 *
 * @Author YuArai
 * @Ver 1.0
 */
class TFISBN {
  public static function convertISBN($isbn) {
    $converted = "";
    switch (strlen($isbn)) {
      case 13:
        $converted = ISBN::convertISBNToTenDigit($isbn);
        break;
      case 10:
        $converted = ISBN::convertISBNToThirtyDigit($isbn);
        break;
      default:
        throw new Exception('ISBNは10桁または13桁で指定してください');
        break;
    }

    return $converted;
  }

  /**
   * ISBN 10 桁から 13 桁に変換する
   */
  public static function convertISBNToThirtyDigit($isbn10) {
    $prefix = 978;
    $checkModulus = 10;

    $tmpIsbn = $prefix.substr($isbn10, 0, -1);

    $checksum = 0;
    for ($i = 0; $i < strlen($tmpIsbn); $i++) {
      $char = substr($tmpIsbn, $i, 1);
      $weight = 3;
      if (($i % 2) == 0) $weight = 1;
      $checksum = $checksum + intval($char) * $weight;
    }

    $checkdigit = $checkModulus - ($checksum % $checkModulus);

    return $tmpIsbn.$checkdigit;
  }

  /**
   * ISBN 13 桁から 10 桁に変換する
   */
  public static function convertISBNToTenDigit($isbn13) {
    $checkModulus = 11;
    $checksumWeight = 10;

    $isbn9 = substr($isbn13, 3, -1);

    $checksum = 0;
    for ($i = 0; $i < strlen($isbn9); $i++) {
      $char = substr($isbn9, $i, 1);
      $checksum = $checksum + intval($char) * ($checksumWeight - $i);
    }
    $checkdigit = $checkModulus - $checksum % $checkModulus;
    if ($checkdigit == 11) $checkdigit = 0;
    if ($checkdigit == 10) $checkdigit = "X";

    return $isbn9.$checkdigit;
  }
}
