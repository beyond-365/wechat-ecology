<?php


namespace Beyond\WeChatEcology\Payment\Partner\Ecommerce;

use Beyond\WeChatEcology\Core\BaseProvider;
use Beyond\WeChatEcology\Payment\Marketing\Busifavor\Stock;

/**
 * 微信支付->服务商->收付通
 *
 * Class EcommerceProvider
 * @package Beyond\WeChatEcology\Payment\Partner\Ecommerce
 */
class EcommerceProvider extends BaseProvider
{
    /**
     * @return array|mixed
     */
    public function registerList()
    {
        return array_merge(parent::registerList(), [
            'ecommerce' => function ($app) {
                return new Ecommerce($app);
            },
        ]);
    }
}