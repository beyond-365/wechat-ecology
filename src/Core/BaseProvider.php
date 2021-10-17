<?php


namespace Beyond\WeChatEcology\Core;

use Beyond\SmartHttp\Kernel\BaseProvider as Provider;


class BaseProvider extends Provider
{
    /**
     * @inheritDoc
     */
    function registerList()
    {
        return [];
    }
}