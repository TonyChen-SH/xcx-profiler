<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\Filter\FilterIgnoreFile;
use XcxProfiler\Filter\FilterIsSpecifiedExtensionFile;
use XcxProfiler\Filter\FilterNotRef;
use XcxProfiler\Filter\FilterNotUploadToRemote;
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
        switch ($scanType){
            case 'imageNotRef':
                $this->showAllNotRefImage($fullPath);
                break;
            case 'imageNotUploadToRemote':
                $this->notUploadToRemote($fullPath);
                break;
        }
    }

    /**
     * 图片未上传至远端
     * @param string $fullPath
     */
    public function notUploadToRemote(string $fullPath):void {
        #过滤器
        $filter = new FilterIsSpecifiedExtensionFile(
            FilterIsSpecifiedExtensionFile::FILE_TYPE_PNG |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JPG
        );
        $filter->setNextFilter(new FilterSizeGreaterThan(21))->setNextFilter(new FilterIgnoreFile(FilterIgnoreFile::FILE_TYPE_GIT))->
        setNextFilter(new FilterNotUploadToRemote($fullPath));
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList = [];
        echo '开始扫描未上传图片: <br>';
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }

            $fileList[] = $file;
        }
        $fileList = (new OrderBySize($fileList))->sort();
        foreach ($fileList as $file) {
            echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . "kb \n";
            ob_flush();
            flush();
        }
        echo ' <br>扫描结束;';

    }

    public function showAllFile(string $fullPath): void {
        // 过滤器
        $filter = new FilterSizeGreaterThan(3);
        $filter->setNextFilter(new FilterIgnoreFile(FilterIgnoreFile::FILE_TYPE_GIT))
            ->setNextFilter(new FilterNotRef($fullPath));
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $fileList = [];
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
        $fileList = [];
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

        $a=1;
        echo '扫描结束!';

        // $fileList = (new OrderBySize($fileList))->sort();
        // foreach ($fileList as $file) {
        //     echo 'name:' . $file->getName() . ' size:' . $file->getKbSize() . "kb \n";
        // }
    }
}