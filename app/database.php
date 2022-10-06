<?php

class Database
{
  private $dbHost = '127.0.0.1';
  private $dbUser = 'root';
  private $dbPass = '';
  private $dbName = 'web0';
  private $port = 3306;
  private $dbOption = [
    // PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];

  private $dbh;

  private $stmt;

  public function __construct()
  {
    $dsn = "mysql:host={$this->dbHost};port={$this->port};dbname={$this->dbName};";
    try {
      $this->dbh = new PDO($dsn, $this->dbUser, $this->dbPass, $this->dbOption);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function query($query)
  {
    $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $this->dbh->query($query);
  }

  public function prepare($query)
  {
    $this->stmt = $this->dbh->prepare($query);
    return $this;
  }

  public function bindValue($param, $var, $type = null)
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

  public function execute($params = null)
  {
    if (is_null($params)) {
      $this->stmt->execute();
    } else {
      $this->stmt->execute($params);
    }
    return $this;
  }

  public function fetch($executeParams = null)
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetch(PDO::FETCH_NUM);

    return ($result == false) ? false : $result[0];
  }

  public function fetchAll($executeParams = null)
  {
    $this->execute($executeParams);
    $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  public function quote($string)
  {
    return $this->dbh->quote($string);
  }
}
