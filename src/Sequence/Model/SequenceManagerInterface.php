<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */

namespace Sequence\Model;


interface SequenceManagerInterface
{
    public function getNext($sequenceName);
} 