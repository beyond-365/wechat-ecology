<?php


namespace Beyond\WeChatEcology\Payment\Marketing\Busifavor;


use Beyond\WeChatEcology\Core\BaseProvider;

/**
 * 微信支付->营销->商家券
 *
 * Class StockProvider
 * @package Beyond\WeChatEcology\Payment\Marketing\Busifavor
 */
class StockProvider extends BaseProvider
{
    /**
     * @return array|mixed
     */
    public function registerList()
    {
        return array_merge(parent::registerList(), [
            'busifavor_stock' => function ($app) {
                return new Stock($app);
            },
        ]);
    }
}