<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;

/**
 * 过滤器
 * Class Filter
 * @package XcxProfiler\Filter
 */
abstract class Filter {
    /**
     * 链式过滤器的时候,下一个过滤器对象
     * @var Filter
     */
    private $nextFilter;

    public function getNextFilter(): Filter {
        return $this->nextFilter;
    }

    public function setNextFilter(Filter $nextFilter): self {
        $this->nextFilter = $nextFilter;
        return $this->nextFilter;
    }

    public function hasNextFilter(): bool {
        return $this->nextFilter !== null;
    }

    /**
     * 开始过滤
     * @param File $file
     * @return bool
     */
    abstract public function doFilter(File $file): bool;
}