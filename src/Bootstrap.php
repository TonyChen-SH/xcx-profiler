<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\Filter\FilterIgnoreFile;
use XcxProfiler\Filter\FilterIsSpecifiedExtensionFile;
use XcxProfiler\Filter\FilterNotRef;
use XcxProfiler\Filter\FilterSizeGreaterThan;
use XcxProfiler\Sort\OrderBySize;

/**
 * 启动类
 * Class Bootstrap
 */
class Bootstrap {
    public function __construct() {

    }

    public function showAllFile(string $fullPath): void {
        // 过滤器
        $filter = new FilterSizeGreaterThan(3);
        $filter->setNextFilter(new FilterIgnoreFile(FilterIgnoreFile::FILE_TYPE_GIT))
               ->setNextFilter(new FilterNotRef($fullPath));
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList    = [];
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }

            $fileList[] = $file;
        }

        $fileList = (new OrderBySize($fileList))->sort();
        foreach ($fileList as $file) {
            echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . "kb \n";
        }
    }

    // 所有未被引用的图片
    public function showAllNotRefImage(string $fullPath): void {
        // 过滤器
        $filter = new FilterIsSpecifiedExtensionFile(
            FilterIsSpecifiedExtensionFile::FILE_TYPE_PNG |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JPG
        );
        $filter->setNextFilter(new FilterNotRef($fullPath));
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList    = [];
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }

            $fileList[] = $file;
        }

        $fileList = (new OrderBySize($fileList))->sort();
        foreach ($fileList as $file) {
            echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . "kb \n";
        }
    }
}