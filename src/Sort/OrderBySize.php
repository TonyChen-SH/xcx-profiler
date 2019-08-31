<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Sort;

use XcxProfiler\File;

/**
 * 根据文件大小进行排序
 * Class OrderBySize
 * @package XcxProfiler\Sort
 */
class OrderBySize {
    /**
     * @var File[]
     */
    private $fileList;

    public function __construct(array $fileList) {
        $this->fileList = $fileList;
    }

    public function sort(): array {
        if (empty($this->fileList)) {
            return [];
        }

        $sortedFileList = [];
        foreach ($this->fileList as $file) {
            $sortedFileList[$file->getSize()] = $file;
        }
        krsort($sortedFileList, SORT_NUMERIC);
        return $sortedFileList;
    }

}