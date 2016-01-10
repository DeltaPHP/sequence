<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model;

use DeltaDb\Parts\DbaInclude;

interface SequenceManagerInterface
{
    public function getNext($sequenceName = "default");
} 