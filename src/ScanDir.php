<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * 扫描文件夹
 * Class RecursiveDir
 */
class ScanDir {
    private static $instanceList = [];
    /**
     * 迭代器
     * @var RecursiveDirectoryIterator
     */
    private $recursiveDirectoryIterator;

    /**
     * @var File[]
     */
    private $allFile;

    /**
     * 项目路径
     * RecursiveDir constructor.
     * @param string $fullPath 完整路径: /tmp/xxx/
     */
    private function __construct(string $fullPath) {
        $this->recursiveDirectoryIterator = new RecursiveDirectoryIterator($fullPath);
    }

    public static function getInstance(string $fullPath): self {
        if (empty(self::$instanceList[$fullPath])) {
            self::$instanceList[$fullPath] = new self($fullPath);
        }

        return self::$instanceList[$fullPath];
    }

    /**
     * 从指定目录中查找指定文件名的文件
     * @param $fileName
     */
    public function find($fileName) {

    }

    /**
     * 指定目录下的所有文件
     * @return File[]
     */
    public function getAllFile(): array {
        if (empty($this->allFile)) {
            $iterator = new RecursiveIteratorIterator($this->recursiveDirectoryIterator);
            $files    = [];
            foreach ($iterator as $splFileInfo) {
                /**
                 * @var SplFileInfo $splFileInfo
                 */
                if ($splFileInfo->isDir()) {
                    continue;
                }

                $files[] = new File(
                    $splFileInfo->getPathname(),
                    $splFileInfo->getFilename(),
                    $splFileInfo->getSize(),
                    $splFileInfo->getPath(),
                    $splFileInfo->getExtension()
                );
            }

            $this->allFile = $files;
        }

        return $this->allFile;
    }
}