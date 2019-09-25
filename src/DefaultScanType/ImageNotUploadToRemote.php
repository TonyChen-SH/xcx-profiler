<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\DefaultScanType;

use XcxProfiler\File;
use XcxProfiler\Filter\Filter;
use XcxProfiler\Filter\FilterIsSpecifiedExtensionFile;
use XcxProfiler\Filter\FilterNotUploadToRemote;
use XcxProfiler\Filter\FilterSizeGreaterThan;
use XcxProfiler\ScanDir;

class ImageNotUploadToRemote extends DefScanBase {
    /**
     * 获取过滤器列表
     * @return Filter
     */
    protected function getFilerChain(): Filter {
        #过滤器
        $filter = new FilterIsSpecifiedExtensionFile(
            FilterIsSpecifiedExtensionFile::FILE_TYPE_PNG |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JPG
        );
        $filter->setNextFilter(new FilterSizeGreaterThan(21))
               ->setNextFilter(new FilterNotUploadToRemote($this->getScanFullPath()));
        return $filter;
    }

    /**
     * 获取要被过滤的文件列表
     * @return File[]
     */
    protected function getCheckFiles(): array {
        return ScanDir::getInstance($this->getScanFullPath())->getAllFile();
    }
}