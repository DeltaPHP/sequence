<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Parts;

use Sequence\Model\SequenceManager;
use Sequence\Model\SequenceManagerInterface;

trait Sequence
{
    /** @var  SequenceManager */
    protected $sequenceManager;

    /**
     * @return SequenceManager
     */
    public function getSequenceManager()
    {
        return $this->sequenceManager;
    }

    /**
     * @param SequenceManager $sequenceManager
     */
    public function setSequenceManager(SequenceManagerInterface $sequenceManager)
    {
        $this->sequenceManager = $sequenceManager;
    }

}