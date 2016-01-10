<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model;


use DeltaCore\Parts\Configurable;
use DeltaDb\Parts\DbaInclude;
use DeltaUtils\StringUtils;
use Sequence\Model\Adapter\MysqlSequence;
use Sequence\Model\Adapter\PgSequence;
use Sequence\Model\Adapter\SequenceAdapterInterface;

class SequenceManager implements SequenceManagerInterface
{
    use DbaInclude;
    use Configurable;

    /** @var array SequenceAdapterInterface[] */
    protected $adapters = [];
    protected $default;

    /**
     * @return SequenceAdapterInterface|PgSequence
     * @throws \Exception
     */
    public function getAdapter($adapter = "default")
    {
        $adapterName = StringUtils::cutClassName($adapter);
        if ($adapterName === "default") {
            if (is_null($this->default)) {
                $dba = $this->getDba();
                if ($dba instanceof \DeltaDb\Adapter\PgsqlAdapter) {
                    $defaultAdapter = $this->getConfig("adapter", "PgSequence");
                } elseif ($dba instanceof \DeltaDb\Adapter\MysqlPdoAdapter) {
                    $defaultAdapter = "MysqlSequence";
                } else {
                    throw new \Exception("Sequence adapter for dba not found");
                }
                $this->default = $defaultAdapter;
            }
            return $this->getAdapter($this->default);
        }
        if (!StringUtils::isFullClass($adapter)) {
            $adapter = "\\Sequence\\Model\\Adapter\\" . $adapter;
        }
        $this->adapters[$adapterName] = new $adapter();
        $this->adapters[$adapterName]->setDba($this->getDba());
        $this->adapters[$adapterName]->setConfig($this->getConfig());

        return $this->adapters[$adapterName];
    }

    public function getSequences()
    {
        $sequences = $this->getConfig()->get(["Sequence", "sequences"], ["default"])->toArray();
        return $sequences;
    }

    public function getNext($sequenceName = "default")
    {
        $sequences = array_flip($this->getSequences());
        if (!isset($sequences[$sequenceName])) {
            return null;
        }
        $adapter = $this->getAdapter();
        return $adapter->getNext($sequenceName);
    }
}
