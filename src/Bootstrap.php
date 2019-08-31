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
use function flush;
use function ob_flush;

/**
 * 启动类
 * Class Bootstrap
 */
class Bootstrap {
    public function __construct() {

    }

    public function scan(string $fullPath, string $scanType): void {
        $this->showAllNotRefImage($fullPath);
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
        echo '开始扫描: <br>';
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }

            // echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . 'kb <br>';
            echo $file->getKbSize() . 'kb &nbsp;&nbsp;&nbsp;&nbsp;' . $file->getName() . '<br>';
            ob_flush();
            flush();
            // $fileList[] = $file;
        }
        echo '扫描结束!';

        // $fileList = (new OrderBySize($fileList))->sort();
        // foreach ($fileList as $file) {
        //     echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . "kb \n";
        // }
    }
}