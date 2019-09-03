<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;
use XcxProfiler\Utils;
use function file_get_contents;
use function strpos;

/**
 * 没有被引用
 *    需要配合png/gif/js等过滤出来的文件类型使用
 * Class FilterNotRef
 * @package XcxProfiler\Filter
 */
class FilterNotRef extends Filter {
    /**
     * @var string
     */
    private $refAtPath;

    public function __construct(string $refAtPath) {
        $this->refAtPath = $refAtPath;
    }

    public function accept(File $file): bool {
        $refFileList = Utils::getCodeFileList($this->refAtPath);
        foreach ($refFileList as $refFile) {
            $text = file_get_contents($refFile->getName());
            if (empty($text)) {
                continue;
            }

            // 有文件使用这个资源，并且使用的不是远端资源
            if (strpos($text, $file->getShortName())) {
                if (!Utils::isUploadToRemote($text,$file)){
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