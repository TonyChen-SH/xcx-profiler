<?php
/**
 * Author: Tony Chen
 */

use Codeception\Test\Unit;
use XcxProfiler\Bootstrap;

class BootstrapTest extends Unit {

    public function testShowAllFile(): void {
        (new Bootstrap())->showAllFile('/tmp');
    }

    public function testShowAllNotRefImage(): void {
        (new Bootstrap())->showAllNotRefImage('/usr/local/var/www/company/xingchuang/baodao_member_plus');
    }
}
