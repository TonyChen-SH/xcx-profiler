<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler\DefaultScanType;

use XcxProfiler\File;
use XcxProfiler\Filter\Filter;
use function flush;
use function ob_flush;

/**
 * 扫描抽象类
 * Class DefScanBase
 * @package XcxProfiler\DefScanType
 */
abstract class DefScanBase {
    /**
     * 指定的扫描路径
     * @var string
     */
    private $scanFullPath;

    public function __construct(string $scanFullPath) {
        $this->scanFullPath = $scanFullPath;
    }

    public function scan(): void {
        $allFileList = $this->getCheckFiles();
        $filter      = $this->getFilerChain();
        echo '开始扫描: <br>';
        foreach ($allFileList as $file) {
            if (!$filter->accept($file)) {
                continue;
            }

            echo $file->getKbSize() . 'kb &nbsp;&nbsp;&nbsp;&nbsp;' . $file->getName() . '<br>';
            ob_flush();
            flush();

            $fileList[] = $file;
        }
        echo ' <br>扫描结束!';
    }

    public function getScanFullPath(): string {
        return $this->scanFullPath;
    }

    /**
     * 获取过滤器链条
     * @return Filter
     */
    abstract protected function getFilerChain(): Filter;

    /**
     * 获取要被过滤的文件列表
     * @return File[]
     */
    abstract protected function getCheckFiles(): array;
}