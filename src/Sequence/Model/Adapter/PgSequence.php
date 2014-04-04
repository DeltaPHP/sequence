<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Adapter;


use DeltaDb\Adapter\PgsqlAdapter;

class PgSequence
{
    /** @var  PgsqlAdapter */
    protected $dba;

    function __construct(PgsqlAdapter $dao)
    {
        $this->setDba($dao);
    }

    /**
     * @param \DeltaDb\Adapter\PgsqlAdapter $dao
     */
    public function setDba(PgsqlAdapter $dao)
    {
        $this->dba = $dao;
    }

    /**
     * @return \DeltaDb\Adapter\PgsqlAdapter
     */
    public function getDba()
    {
        return $this->dba;
    }

    public function getSequences()
    {
        $dba = $this->getDba();
        $sql = "select relname from pg_catalog.pg_statio_all_sequences";
        $sequences = $dba->selectCol($sql);
        return $sequences;
    }

    public function checkSequence($sequenceName)
    {
        $sequences = array_flip($this->getSequences());
        if (isset($sequences[$sequenceName])) {
            return true;
        }
        $sql = "CREATE SEQUENCE {$sequenceName}";
        $dba = $this->getDba();
        return $dba->query($sql);
    }

    public function getNext($sequenceName)
    {
        $this->checkSequence($sequenceName);
        $dba =$this->getDba();
        $sql = "SELECT nextval('{$sequenceName}');";
        $next = $dba->selectCell($sql);
        return $next;
    }
} 