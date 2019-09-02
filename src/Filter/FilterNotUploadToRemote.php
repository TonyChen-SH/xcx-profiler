<?php
namespace XcxProfiler\Filter;

use XcxProfiler\File;
use XcxProfiler\Utils;

//未上传的图片
class FilterNotUploadToRemote extends Filter{

    private $refAtPath;

    public function __construct(string $refAtPath) {
        $this->refAtPath = $refAtPath;
    }

    /**
     * 是否接受(保留)这个文件
     * @param File $file
     * @return bool
     */
    public function accept(File $file): bool {
        $refFileList = Utils::getCodeFileList($this->refAtPath);
        foreach ($refFileList as $refFile) {
            $text = file_get_contents($refFile->getName());

            if (empty($text)) {
                continue;
            }
            //图片出现的位置
            $imgStrPosition = strpos($text, $file->getShortName());
            // 有文件使用这个图片
            if ($imgStrPosition) {
                $httpStrPosition = strrpos(substr($text,0,$imgStrPosition),'http');
                if ($httpStrPosition){
                   $imgUrl = substr($text,$httpStrPosition,($imgStrPosition+strlen($file->getShortName()))-$httpStrPosition);
                   $imgText = @file_get_contents($imgUrl);
                   if (!empty($imgText)){
                       return false;
                   }
                }
            }
        }

        // 如果没有子过滤器，就直接返回
        if (!$this->hasNextFilter()) {
            return true;
        }
        return $this->getNextFilter()->accept($file);
    }
}