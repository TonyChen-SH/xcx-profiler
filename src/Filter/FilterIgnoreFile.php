<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;
use function strpos;

/**
 * 忽略掉git仓库里面的文件
 * Class FilterGitFile
 * @package XcxProfiler\Filter
 */
class FilterIgnoreFile extends Filter {
    public const FILE_TYPE_GIT = '.git';

    /**
     * @var string
     */
    private $fileNameContain;

    public function __construct(string $fileNameContain) {
        $this->fileNameContain = $fileNameContain;
    }

    public function doFilter(File $file): bool {
        // 是git文件
        if (strpos($file->getName(), $this->fileNameContain)) {
            return false;
        }

        // 不是git文件就走下一个
        // 让下一个过滤器，继续做处理
        if ($this->hasNextFilter()) {
            return $this->getNextFilter()->doFilter($file);
        }

        return true;
    }
}