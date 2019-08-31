<?php
/**
 * Author: Tony Chen
 */

use XcxProfiler\Bootstrap;

include __DIR__ . '/../vendor/autoload.php';


(new Bootstrap())->showAllNotRefImage('/Users/chendan/Project/work-jooj/baodao_member_plus');

// PHP 实时的输出结果
// echo str_repeat(' ', 1024);
// for ($i = 0; $i < 10; $i++) {
//     echo $i . "<br>";
//     ob_flush();
//     flush();
//     sleep(1);
// }