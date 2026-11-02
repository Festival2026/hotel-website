<?php
// app/models/statistic_model.php

require_once 'app/core/BaseActiveRecord.php';

class StatisticModel extends BaseActiveRecord
{
    protected static $tablename = 'statistics';

    public $visit_time;
    public $web_page;
    public $ip_address;
    public $host_name;
    public $browser_name;
}