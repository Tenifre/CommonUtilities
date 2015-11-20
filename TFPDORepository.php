<?php
/**
 * PDO使う時の簡単なユーティリティ
 *
 * @Author YuArai
 * @Ver 1.0
 */

class TFPDORepository {
  protected $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  /**
   * 値のバインド
   */
  private function bindValues($stmt, $bindData) {
    if (!is_null($bindData) && (is_array($bindData) || is_object($bindData))) {
      foreach ($bindData as $key => $value) {
        $type = PDO::PARAM_STR;
        if (is_numeric($value)) $type = PDO::PARAM_INT;
        $stmt->bindValue(":".$key, $value, $type);
      }
    }

    return $stmt;
  }

  /**
   * 結果セットを取得
   */
  public function getResultSet($stmt, $bindData=null) {

    $this->bindValues($stmt, $bindData);
    $ret = $stmt->execute();

    $ret = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
      $ret[] = $row;
    }

    return $ret;
  }

  /**
   * アップデートを実行
   */
  public function updateExec($stmt, $bindData=null) {

    $this->bindValues($stmt, $bindData);
    $ret = $stmt->execute();

    return $ret;
  }

  /**
   * データを追加し、IDを取得
   */
  public function insertAndGetId($stmt, $bindData=null) {

    $this->bindValues($stmt, $bindData);
    $ret = $stmt->execute();

    if (!$ret) return $ret;

    return $this->pdo->lastInsertId();
  }
}
