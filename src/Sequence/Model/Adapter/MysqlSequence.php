<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Adapter;


use DeltaCore\Parts\Configurable;
use DeltaDb\Adapter\MysqlPdoAdapter;
use DeltaDb\Parts\DbaInclude;

class MysqlSequence implements SequenceAdapterInterface
{
    use DbaInclude;
    use Configurable;

    public function getTable()
    {
        return $this->getConfig()->get(["Sequence", "table"], "sequences");
    }

    public function getSequences()
    {
        $dba = $this->getDba();
        $table = $this->getTable();
        $sql = "select `name` from {$table}";
        $sequences = $dba->selectCol($sql);
        return $sequences;
    }

    public function checkSequence($sequenceName)
    {
        $sequences = array_flip($this->getSequences());
        if (isset($sequences[$sequenceName])) {
            return true;
        }
        /** @var MysqlPdoAdapter $dba */
        $dba = $this->getDba();
        $table = $this->getTable();
        $sql = "insert into {$table} (`name`, `value`) values(?, ?)";
        return $dba->queryParams($sql, [$sequenceName, 1]);
    }

    public function getNext($sequenceName)
    {
        $this->checkSequence($sequenceName);
        $dba = $this->getDba();
        $table = $this->getTable();
        $sql = "SELECT `value` FROM {$table} where `name`=? FOR UPDATE;";
        $next = $dba->selectCell($sql, $sequenceName);
        $sql = "UPDATE {$table} SET `value` = `value` + 1 where `name` = ?";
        $dba->queryParams($sql,[$sequenceName]);
        return $next;
    }
} 