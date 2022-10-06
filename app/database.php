<?php

class Database
{
  private string $dbHost = '127.0.0.1';
  private string $dbUser = 'root';
  private string $dbPass = '';
  private string $dbName = 'web0';
  private int $port = 3306;
  private array $dbOption = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];

  private PDO $dbh;

  private PDOStatement $stmt;

  public function __construct()
  {
    $dsn = "mysql:host={$this->dbHost};port={$this->port};dbname={$this->dbName};";
    try {
      $this->dbh = new PDO($dsn, $this->dbUser, $this->dbPass, $this->dbOption);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function query(string $query)
  {
    $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $this->dbh->query($query);
  }

  public function prepare(string $query)
  {
    $this->stmt = $this->dbh->prepare($query);
    return $this;
  }

  public function bindValue(mixed $param, mixed $var, ?int $type = null)
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

  public function execute(?array $params = null)
  {
    if (is_null($params)) {
      $this->stmt->execute();
    } else {
      $this->stmt->execute($params);
    }
    return $this;
  }

  public function fetch(?array $executeParams = null)
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetch(PDO::FETCH_NUM);

    return ($result == false) ? false : $result[0];
  }

  public function fetchAll(?array $executeParams = null)
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  public function quote(string $string)
  {
    return $this->dbh->quote($string);
  }
}
