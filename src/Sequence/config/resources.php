<?php
/**
 * User: Vasiliy Shvakin (orbisnull) zen4dev@gmail.com
 */
return [
    "sequenceManager" => function($c) {
            $sm = new \Sequence\Model\SequenceManager();
            $config = $c->getConfig("Sequence");
            $sm->setConfig($config);
            $dba = \DeltaDb\DbaStorage::getDba();
            $sm->setDba($dba);
            return $sm;
        }
];