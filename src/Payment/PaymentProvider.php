<?php


namespace Beyond\WeChatEcology\Payment;


use Beyond\WeChatEcology\Core\BaseProvider;
use Beyond\WeChatEcology\Middleware\Payment\WeChatPayMiddleware;

class PaymentProvider extends BaseProvider
{
    /**
     * @return array|mixed
     */
    public function registerList()
    {
        return array_merge(parent::registerList(), [
            // 注册微信支付中间件
            WechatPayMiddleware::getAccessName() => function ($app) {
                return new WechatPayMiddleware($app);
            },
        ]);
    }
}