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

            // 有文件使用这个图片并且上传到远端
            if (strpos($text, $file->getShortName())) {
                if (Utils::isUploadToRemote($text,$file)){
                    return false;
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