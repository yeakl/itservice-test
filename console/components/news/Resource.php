<?php

namespace console\components\news;

abstract class Resource
{
    public $url;
    public $limit = 20;
    public $records = [];

    /**
     * @return Record[]
     */
    public function getRecords(): array { return $this->records; }
}
