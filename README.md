# CommonUtilities
なんか細々とした色々なものの置き場所

## TFISBN
10桁 / 13桁の変換

```
TFISBN::convertISBN(9784063842760) # => 4063842762
TFISBN::convertISBN(4063842762) # => 9784063842760
```

## TFPDORepository
PDOのユーティリティ<br>
bindValueとか何度も打つの面倒なので

```
class UserRepository extends TFPDORepository {
  public function __construct($pdo) {
    parent::__construct($pdo)
  }
  
  public function getUserById($id) {
    $sql = "SELECT * FROM user WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    
    return $this->getResultSet($stmt, array("id" => $id));
  }
  
  public function insertUser($data) {
    $sql = "INSERT INTO user (username, password) VALUES (:username, :password)"
    $stmt = $this->pdo->prepare($sql);
    
    return $this->insertAndGetId($stmt, $data);
  }
  
  public function updateUser($data) {
    $sql = "UPDATE user SET username = :username WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    
    return $this->updateExec($stmt, $data);
  }
}
```
