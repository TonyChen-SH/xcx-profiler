<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use XcxProfiler\Filter\FilterHasFile;

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
        $filter      = new FilterHasFile(FilterHasFile::FILE_TYPE_JS);
        $filter->setNextFilter(new FilterHasFile(FilterHasFile::FILE_TYPE_JSON))
               ->setNextFilter(new FilterHasFile(FilterHasFile::FILE_TYPE_WXML))
               ->setNextFilter(new FilterHasFile(FilterHasFile::FILE_TYPE_WXSS));

        $fileList = [];
        foreach ($allFileList as $file) {
            if (!$filter->doFilter($file)) {
                continue;
            }
            $fileList[] = $file;
        }
        return $fileList;
    }
}