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
 * 没有被引用的本地图片
 * Class NotRefImage
 * @package XcxProfiler\Filter
 */
class FilterNotRefLocalImage extends Filter {
    /**
     * @var string
     */
    private $refAtPath;

    public function __construct(string $refAtPath) {
        $this->refAtPath = $refAtPath;
    }

    public function doFilter(File $file): bool {
        if ($file->getExtension() !== 'png' && $file->getExtension() !== 'jpg') {
            return false;
        }

        $refFileList = Utils::getCodeFileList($this->refAtPath);
        foreach ($refFileList as $refFile) {
            $text = file_get_contents($refFile->getName());
            if (empty($text)) {
                continue;
            }

            // 有文件使用这个图片
            if (strpos($text, $file->getShortName())) {
                return false;
            }
        }

        // 让下一个过滤器，继续做处理
        if ($this->hasNextFilter()) {
            return $this->getNextFilter()->doFilter($file);
        }

        return true;
    }
}