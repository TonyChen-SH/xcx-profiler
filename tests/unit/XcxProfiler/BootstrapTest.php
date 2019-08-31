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
        (new Bootstrap())->showAllNotRefImage('/Users/chendan/Project/work-jooj/baodao_member_plus');
    }
}
