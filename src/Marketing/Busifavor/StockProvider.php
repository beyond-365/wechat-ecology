<?php


namespace Beyond\WeChatEcology\Marketing\Busifavor;


use Beyond\WeChatEcology\Core\BaseProvider;
use Beyond\WeChatEcology\Middleware\WechatPayMiddleware;

class StockProvider extends BaseProvider
{
    /**
     * @return array
     */
    public function registerList()
    {
        return array_merge(parent::registerList(), [
            'busifavor_stock' => function ($app) {
                return new Stock($app);
            },
            // 注册微信支付中间件
             WechatPayMiddleware::getAccessName() => function ($app) {
                return new WechatPayMiddleware($app);
            },
        ]);
    }
}