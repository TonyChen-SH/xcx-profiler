<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\Filter\FilterIgnoreFile;
use XcxProfiler\Filter\FilterNotRefLocalImage;
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
               ->setNextFilter(new FilterNotRefLocalImage($fullPath));
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList    = [];
        foreach ($allFileList as $file) {
            if (!$filter->doFilter($file)) {
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
        $filter      = new FilterNotRefLocalImage($fullPath);
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList    = [];
        foreach ($allFileList as $file) {
            if (!$filter->doFilter($file)) {
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