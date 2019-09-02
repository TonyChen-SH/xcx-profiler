<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\DefScanType;

use XcxProfiler\File;
use XcxProfiler\Filter\Filter;
use XcxProfiler\Filter\FilterIsSpecifiedExtensionFile;
use XcxProfiler\Filter\FilterNotRef;
use XcxProfiler\ScanDir;

class ImageNotRef extends DefScanBase {
    /**
     * 获取过滤器列表
     * @return Filter
     */
    public function getFilerChain(): Filter {
        // 过滤器
        $filter = new FilterIsSpecifiedExtensionFile(
            FilterIsSpecifiedExtensionFile::FILE_TYPE_PNG |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JPG
        );
        $filter->setNextFilter(new FilterNotRef($this->getScanFullPath()));
        return $filter;
    }

    /**
     * 获取要被过滤的文件列表
     * @return File[]
     */
    public function getCheckFiles(): array {
        return ScanDir::getInstance($this->getScanFullPath())->getAllFile();
    }
}