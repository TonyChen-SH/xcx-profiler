<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\Filter\FilterIsSpecifiedExtensionFile;

/**
 * 工具类
 * Class Utils
 * @package XcxProfiler
 */
class Utils {

    /**
     * @param string $fullPath
     * @return File[]
     */
    public static function getCodeFileList(string $fullPath): array {
        $allFileList = ScanDir::getInstance($fullPath)->getAllFile();
        $filter      = new FilterIsSpecifiedExtensionFile(
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JS |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_JSON |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_WXML |
            FilterIsSpecifiedExtensionFile::FILE_TYPE_WXSS
        );

        $fileList = [];
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }
            $fileList[] = $file;
        }
        return $fileList;
    }
}