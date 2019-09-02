<?php
/**
 * Author: Tony Chen
 */

use Codeception\Test\Unit;
use XcxProfiler\ScanDir;

class RecursiveDirTest extends Unit {
    public function testGetAll(): void {
        $list = ScanDir::getInstance('/usr/local/var/www/company/xingchuang/baodao_member_plus')->getAllFile();
        self::assertGreaterThan(0, count($list));
    }

    public function testFind() {
    }
}
