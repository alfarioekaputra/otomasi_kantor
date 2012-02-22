<?php

  class statementPager extends sfDoctrinePager
{
  protected $resultsetArray = array();

  public function __construct($class = null, $maxPerPage = 10)
  {
    parent::__construct($class, $maxPerPage);
  }

  public function setStatement($statement)
  {
    $this->statement = $statement;
  }

  public function init()
  {
    $this->statement->execute();

    $this->setNbResults($this->statement->rowCount());

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
     $this->setLastPage(0);
    }
    else
    {
     $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  public function getResults()
  {

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }

    $row_num = 1;
    while ($resultset = $this->statement->fetch(PDO::FETCH_NUM))
    {
      if ($row_num > $this->getMaxPerPage()*($this->getPage()-1)
      and $row_num <= ($this->getPage()*$this->getMaxPerPage() ))
      {
        $this->resultsetArray[] = $resultset;
      }
      $row_num++;
    }

    return $this->resultsetArray;
  }

  public function retrieveObject($offset)
  {
    return $this->resultsetArray[$offset];

  }
}