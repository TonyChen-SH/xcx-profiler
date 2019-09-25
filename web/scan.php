<?php
/**
 * Author: Tony Chen
 */

use XcxProfiler\Bootstrap;

include __DIR__ . '/../vendor/autoload.php';

$scanPath = $_GET['scanPath'];
$scanType = $_GET['scanType'];
(new Bootstrap())->scan($scanPath, $scanType);