<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model\Adapter;


use DeltaCore\ConfigurableInterface;
use DeltaDb\Parts\DbaIncludeInterface;

interface SequenceAdapterInterface extends ConfigurableInterface, DbaIncludeInterface
{
    public function getNext($sequenceName = "default");
}
