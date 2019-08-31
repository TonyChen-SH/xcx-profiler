<?php
/**
 * Author: Tony Chen
 */

namespace XcxProfiler;

class File {
    /**
     * 完整文件名
     * @var string /Users/Project/work/plus/images/1.jpg
     */
    private $name;

    /**
     * 短文件名
     * @var string 1.jpg
     */
    private $shortName;

    /**
     * 单位: bytes
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $dir;

    /**
     * 文件扩展名
     * @var string png或者gif
     */
    private $extension;

    public function __construct(string $name, string $shortName, int $size, string $dir, string $extension) {
        $this->name      = $name;
        $this->shortName = $shortName;
        $this->size      = $size;
        $this->dir       = $dir;
        $this->extension = $extension;
    }

    public function getShortName(): string {
        return $this->shortName;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function setSize(int $size): void {
        $this->size = $size;
    }

    // 格式化成kb
    public function getKbSize(): int {
        return $this->getSize() / 1024;
    }

    public function getDir(): string {
        return $this->dir;
    }

    public function setDir(string $dir): void {
        $this->dir = $dir;
    }

    public function getExtension(): string {
        return $this->extension;
    }

    public function setExtension(string $extension): void {
        $this->extension = $extension;
    }
}