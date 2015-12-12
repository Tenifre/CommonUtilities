<?php
/**
 * 位置情報の計算
 *
 * @Author Yu Arai
 * @Ver 1.0
 */

class TFDistance {
  public $first_lat;
  public $first_lng;
  public $second_lat;
  public $second_lng;
  private $earth_r = 6378.137; #地球の半径

  public function setFirstPoint($latitude,$longitude) {
    $this->first_lat = $latitude;
    $this->first_lng = $longitude;
  }
  
  public function setSecondPoint($latitude,$longitude) {
    $this->second_lat = $latitude;
    $this->second_lng = $longitude;
  }

  public function getDistance() {
    // 緯度差、経度差をラジアンに変換
    $diff_latit = deg2rad($this->second_lat - $this->first_lat);
    $diff_longi = deg2rad($this->second_lng - $this->first_lng);

    // 南北距離、東西距離を求める
    $height = $this->earth_r * $diff_latit;
    $width = cos(deg2rad($this->first_lat)) * $this->earth_r * $diff_longi;
    
    // 三平方の定理で距離を求める
    $d = sqrt(pow($width,2) + pow($height,2));

    return $d;
  }

  public function getLngByDistance($distance) {
    // 同じ緯度
    $latitude = $this->first_lat;
    
    // longitudeを求める
    $width = $distance;
    $longitude_first = rad2deg($width / ( cos(deg2rad($this->first_lat)) * $this->earth_r )) + $this->first_lng;
    $longitude_second = $this->first_lng - rad2deg($width / ( cos(deg2rad($this->first_lat)) * $this->earth_r ));
    
    // 同じ経度
    $longitude = $this->first_lng;

    // latitudeを求める
    $latitude_first = ( rad2deg( $distance ) / $this->earth_r ) + $this->first_lat;
    $latitude_second = $this->first_lat - ( rad2deg($distance) / $this->earth_r );

    return array("latitude_first"=>$latitude_first,"latitude_second"=>$latitude_second,"longitude_fist"=>$longitude_first,"longitude_second"=>$longitude_second);
  }

}
