<?php

class Database
{
  private string $dbHost = '127.0.0.1';
  private string $dbUser = 'root';
  private string $dbPass = '';
  private string $dbName = 'php_login_system';
  private array $dbOption = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];

  private PDO $dbh;

  private PDOStatement $stmt;

  public function __construct()
  {
    $dsn = "mysql:dbname={$this->dbName};host={$this->dbHost}";
    try {
      $this->dbh = new PDO($dsn, $this->dbUser, $this->dbPass, $this->dbOption);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function query($query): PDOStatement|false
  {
    $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $this->dbh->query($query);
  }

  public function prepare($query): Database
  {
    $this->stmt = $this->dbh->prepare($query);
    return $this;
  }

  public function bindValue(int|string $param, mixed $var, ?int $type = null): Database
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($var):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($var):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($var):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      };
    }

    $this->stmt->bindValue($param, $var, $type);
    return $this;
  }

  public function execute(?array $params = null): Database
  {
    if (is_null($params)) {
      $this->stmt->execute();
    } else {
      $this->stmt->execute($params);
    }
    return $this;
  }

  public function fetch(?array $executeParams = null): mixed
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetch(PDO::FETCH_NUM);

    return ($result == false) ? false : $result[0];
  }

  public function fetchAll(?array $executeParams = null): array
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  public function rowCount(): int
  {
    return $this->stmt->rowCount();
  }

  public function quote(string $string): string|false
  {
    return $this->dbh->quote($string);
  }
}
