<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model;


use DeltaCore\Config;
use DeltaDb\Adapter\AbstractAdapter;
use DeltaDb\Adapter\MysqlPdoAdapter;
use DeltaDb\Adapter\PgsqlAdapter;
use Sequence\Model\Adapter\MysqlSequence;
use Sequence\Model\Adapter\PgSequence;
use Sequence\Model\Adapter\SequenceAdapterInterface;

class SequenceManager implements SequenceManagerInterface
{
    /** @var  Config */
    protected $config;
    /** @var  AbstractAdapter */
    protected $dba;

    protected $adapter;

    /**
     * @param \DeltaCore\Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return \DeltaCore\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \DeltaDb\Adapter\AbstractAdapter $dao
     */
    public function setDba($dao)
    {
        $this->dba = $dao;
    }

    /**
     * @return \DeltaDb\Adapter\AbstractAdapter
     */
    public function getDba()
    {
        return $this->dba;
    }

    /**
     * @return SequenceAdapterInterface|PgSequence
     * @throws \Exception
     */
    public function getAdapter()
    {
        if (is_null($this->adapter)) {
            $dba = $this->getDba();
            if ($dba instanceof PgsqlAdapter) {
                $this->adapter = new PgSequence();
            } elseif ($dba instanceof MysqlPdoAdapter) {
                $this->adapter = new MysqlSequence();
            } else {
                throw new \Exception("Sequence adapter for dba not found");
            }
            $this->adapter->setDba($dba);
            $this->adapter->setConfig($this->getConfig());
        }
        return $this->adapter;
    }

    public function getSequences()
    {
        $sequences = $this->getConfig()->get(["Sequence", "sequences"], [])->toArray();
        return $sequences;
    }

    public function getNext($sequenceName)
    {
        $sequences = array_flip($this->getSequences());
        if (!isset($sequences[$sequenceName])) {
            return null;
        }
        $adapter = $this->getAdapter();
        return $adapter->getNext($sequenceName);
    }







} 