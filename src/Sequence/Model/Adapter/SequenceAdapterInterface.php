<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Adapter;


use DeltaDb\Adapter\AbstractAdapter;

interface SequenceAdapterInterface
{

    public function getSequences();

    public function checkSequence($sequenceName);

    public function getNext($sequenceName);
} 