<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;

/**
 * 大于指定尺寸的文件
 * Class SizeGreaterThan
 * @package XcxProfiler\FilterO
 */
class FilterSizeGreaterThan extends Filter {
    public const UNIT_KB = 'KB';
    public const UNIT_MB = 'MB';
    public const UNIT_GB = 'GB';

    /**
     * 大于指定size
     * @var int
     */
    private $greaterThanSize;

    public function __construct(int $greaterThanSize) {
        $this->greaterThanSize = $greaterThanSize;
    }

    /**
     * 开始过滤
     * @param File $file
     * @return bool
     */
    public function doFilter(File $file): bool {
        // 文件尺寸小于指定的最大尺寸
        if ($file->getKbSize() <= $this->greaterThanSize) {
            return false;
        }

        // 让下一个过滤器，继续做处理
        if ($this->hasNextFilter()) {
            return $this->getNextFilter()->doFilter($file);
        }

        return true;
    }
}