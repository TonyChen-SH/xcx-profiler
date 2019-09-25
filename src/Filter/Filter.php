<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;

/**
 * 过滤器
 *   每个子过滤器连起来的链，都是且的关系. 意思就是说, 文件要满足链上的每个节点条件，才能算符合条件
 *   如： A->B->C ， 那么文件必须同时符合A/B/C 3个规则才算符合条件
 *       执行的顺序是: 满足A条件，才会执行B条件;满足条件B，才会执行C条件;满足条件C，才会所有的条件都满足
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
        return $nextFilter;
    }

    public function hasNextFilter(): bool {
        return $this->nextFilter !== null;
    }

    /**
     * 是否接受(保留)这个文件
     * @param File $file
     * @return bool
     */
    abstract public function accept(File $file): bool;
}