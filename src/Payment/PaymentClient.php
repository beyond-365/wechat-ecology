<?php


namespace Beyond\WeChatEcology\Payment;


use Beyond\WeChatEcology\Core\BaseClient;
use Beyond\WeChatEcology\Middleware\Payment\WeChatPayMiddleware;

class PaymentClient extends BaseClient
{
    public function registerMiddleware()
    {
        parent::registerMiddleware();

        $this->pushMiddlewareByKey(WeChatPayMiddleware::getAccessName());
    }
}