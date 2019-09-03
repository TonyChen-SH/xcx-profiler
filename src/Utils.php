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

    /**
     * 判断被引用图片是否是远端资源
     * @param string $codeText
     * @param FIle $file
     * @return bool
     */
    public static function isUploadToRemote(string $codeText,FIle $file):bool {
        //图片出现的位置
        $imgStrPosition = strpos($codeText, $file->getShortName());
        //截取http字符串出现的位置
        $httpStrPosition = strrpos(substr($codeText,0,$imgStrPosition),'http');
        //如果http字符串存在
        if ($httpStrPosition){
            //截取图片url
            $imgUrl = substr($codeText,$httpStrPosition,($imgStrPosition+strlen($file->getShortName()))-$httpStrPosition);
            //获取图片
            $imgText = @file_get_contents($imgUrl);
            //图片资源不存在
            if (empty($imgText)){
                return false;
            }
            return true;
        }
        return false;
    }
}