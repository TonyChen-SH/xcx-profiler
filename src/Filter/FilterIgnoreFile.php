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

    /**
     * @inheritDoc
     */
    public function accept(File $file): bool {
        // 文件名中包含指定名称,就不接受
        if (strpos($file->getName(), $this->fileNameContain)) {
            return false;
        }
        // 如果没有子过滤器，就直接返回
        if (!$this->hasNextFilter()) {
            return true;
        }

        return $this->getNextFilter()->accept($file);
    }
}