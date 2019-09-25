<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\Filter;

use XcxProfiler\File;

/**
 * 筛选出是指定文件名的文件
 * Class FilterIgnoreFile
 * @package XcxProfiler\Filter
 */
class FilterIsSpecifiedExtensionFile extends Filter {
    // 文件是类型是代码
    public const FILE_TYPE_JS   = 1; // .js
    public const FILE_TYPE_JSON = 2; // .json
    public const FILE_TYPE_WXSS = 4; // .wxss
    public const FILE_TYPE_WXML = 8; // .wxml

    // 文件类型是图片
    public const FILE_TYPE_JPG = 16; // .jpg
    public const FILE_TYPE_PNG = 32; // .png

    /**
     * 包含指定的名称
     * @var string
     */
    private $containExtension;

    public function __construct(int $containExtension) {
        $this->containExtension = $containExtension;
    }

    /**
     * @inheritDoc
     */
    public function accept(File $file): bool {
        $hasFile = false;
        // js文件
        if ($this->hasExtension(self::FILE_TYPE_JS)) {
            $hasFile = ($file->getExtension() === 'js') || $hasFile;
        }
        // json文件
        if ($this->hasExtension(self::FILE_TYPE_JSON)) {
            $hasFile = ($file->getExtension() === 'json') || $hasFile;
        }
        // wxss
        if ($this->hasExtension(self::FILE_TYPE_WXSS)) {
            $hasFile = ($file->getExtension() === 'wxss') || $hasFile;
        }
        // wxml
        if ($this->hasExtension(self::FILE_TYPE_WXML)) {
            $hasFile = ($file->getExtension() === 'wxml') || $hasFile;
        }
        // jpg
        if ($this->hasExtension(self::FILE_TYPE_JPG)) {
            $hasFile = ($file->getExtension() === 'jpg') || $hasFile;
        }
        // png
        if ($this->hasExtension(self::FILE_TYPE_PNG)) {
            $hasFile = ($file->getExtension() === 'png') || $hasFile;
        }

        // 文件不符合任意条件
        if (!$hasFile) {
            return false;
        }
        // 符合条件，且如果没有子过滤器，就直接返回
        if (!$this->hasNextFilter()) {
            return true;
        }
        return $this->getNextFilter()->accept($file);


        // $hasName = strpos($file->getName(), $this->containExtension) !== false;
        // // 没有子过滤器,匹配的结果便是结果.
        // if (!$this->hasNextFilter()) {
        //     return $hasName;
        // }
        //
        // // 由于是查找包含的文件
        // // 如果子过滤器，也是自己.父过滤器和子过滤器是或的关系，二则满足一个就可以了
        // // 如果子过滤器，不是自己.父过滤器和子过滤器是且的关系，而且必须都得满足
        // // ---------------------------------------------------------------
        // // 1.子过滤器是自己，自己或者子过滤器匹配上都算
        // if ($this->getNextFilter() instanceof self) {
        //     // 前后有关系???
        //     return $this->getNextFilter()->accept($file) || $hasName;
        // }
        // // 2.子过滤器不是自己，名字又被匹配上了，就让下一个过滤器继续处理
        // if ($hasName) {
        //     return $this->getNextFilter()->accept($file);
        // }
        // // 3.直接反馈匹配结果
        // return $hasName;
    }

    /**
     * 是否包含指定扩展类型的文件
     * @param int $extension
     * @return bool
     */
    private function hasExtension(int $extension): bool {
        return ($this->containExtension & $extension) === $extension;
    }
}