<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\DefaultScanType\ImageNotRef;
use XcxProfiler\DefaultScanType\ImageNotUploadToRemote;
use XcxProfiler\Filter\FilterIgnoreFile;
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

    public function scan(string $fullPath, string $scanType): void {
        switch ($scanType) {
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
    public function notUploadToRemote(string $fullPath): void {
        (new ImageNotUploadToRemote($fullPath))->scan();
    }

    /**
     * 所有未被引用的图片
     * @param string $fullPath
     */
    public function showAllNotRefImage(string $fullPath): void {
        (new ImageNotRef($fullPath))->scan();
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


}