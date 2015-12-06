<?php
/**
 * 簡単な暗号化
 * @require php mcrypt
 *
 * @Author YuArai
 * @Ver 1.0
 */
class TFCrypting {
  private $key = 'owidj72jshsu827s';
  private $iv;
  private $resource;

  function __construct() {
    $this->resource = mcrypt_module_open(MCRYPT_BLOWFISH, '',  MCRYPT_MODE_CBC, '');
    
    $ks = mcrypt_enc_get_key_size($this->resource);
    $this->key = substr(md5($this->key), 0, $ks);
    
    $ivsize = mcrypt_enc_get_iv_size($this->resource);
    $this->iv = substr(md5($this->key), 0, $ivsize);
  }

  public function doCrypt($data) {
    mcrypt_generic_init($this->resource, $this->key, $this->iv);
    $base64_data = base64_encode($data);
    $encrypted_data = mcrypt_generic($this->resource, $base64_data);
    mcrypt_generic_deinit($this->resource);
    
    return base64_encode($encrypted_data);
  }

  public function deCrypt($data) {
    mcrypt_generic_init($this->resource, $this->key, $this->iv);
    $encrypted_data = base64_decode($data);
    $base64_decrypted_data = mdecrypt_generic($this->resource, $encrypted_data);
    $decrypted_data = base64_decode($base64_decrypted_data);
    mcrypt_generic_deinit($this->resource);
    
    return $decrypted_data;
  }

  public function __destruct() {
    mcrypt_module_close($this->resource);
  }
}
