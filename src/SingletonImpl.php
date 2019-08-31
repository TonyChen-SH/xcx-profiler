<?php

namespace XcxProfiler;

/**
 *  通用单例模式声明
 * @author Tony Chen
 * trait SingletonImpl
 */
trait SingletonImpl {
    private static $instance;

    private function __construct() {
    }

    /**
     * @return self
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __clone() {
    }
}