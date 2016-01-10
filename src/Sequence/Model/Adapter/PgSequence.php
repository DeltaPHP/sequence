<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Adapter;


use DeltaDb\Parts\DbaInclude;

class PgSequence implements SequenceAdapterInterface
{
    use DbaInclude;

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

    public function getNext($sequenceName = "default")
    {
        $this->checkSequence($sequenceName);
        $dba =$this->getDba();
        $sql = "SELECT nextval('{$sequenceName}');";
        $next = $dba->selectCell($sql);
        return $next;
    }
} 