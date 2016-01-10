<?php
/**
 * Created by PhpStorm.
 * User: orbisnull
 * Date: 06.01.16
 * Time: 2:18
 */

namespace Sequence\Model\Adapter;

use DeltaCore\Parts\Configurable;
use DeltaDb\Parts\DbaInclude;

class PgSequenceUuidComplexShort implements SequenceAdapterInterface
{
    use Configurable;
    use DbaInclude;

    public function getNext($sequenceName = "default")
    {
        $sql = "SELECT uuid_short_complex();";
        $dba = $this->getDba();
        $next = $dba->selectCell($sql);
        return $next;
    }
}
