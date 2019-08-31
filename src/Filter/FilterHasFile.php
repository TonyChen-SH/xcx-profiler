<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;
use function strpos;

/**
 *
 * 包含指定文件名的文件
 * Class FilterIgnoreFile
 * @package XcxProfiler\Filter
 */
class FilterHasFile extends Filter {
    // 文件是类型是代码
    public const FILE_TYPE_JS   = '.js';
    public const FILE_TYPE_JSON = '.json';
    public const FILE_TYPE_WXSS = '.wxss';
    public const FILE_TYPE_WXML = '.wxml';

    // 文件类型是图片
    public const FILE_TYPE_JPG = '.jpg';
    public const FILE_TYPE_PNG = '.png';

    /**
     * @var string
     */
    private $fileNameContain;

    public function __construct(string $fileNameContain) {
        $this->fileNameContain = $fileNameContain;
    }

    public function doFilter(File $file): bool {
        // 包含指定文件名的文件
        if (strpos($file->getName(), $this->fileNameContain)) {
            return true;
        }

        // 让下一个过滤器，继续做处理
        if ($this->hasNextFilter()) {
            return $this->getNextFilter()->doFilter($file);
        }
        return false;
    }
}