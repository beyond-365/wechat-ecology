<?php


namespace Beyond\WeChatEcology;

use Beyond\SmartHttp\Application as BaseApplication;
use Beyond\WeChatEcology\Payment\Marketing\Busifavor\Stock;
use Beyond\WeChatEcology\Payment\Marketing\Busifavor\StockProvider;
use Beyond\WeChatEcology\Payment\Partner\Ecommerce\EcommerceProvider;


class WXApplication extends BaseApplication
{
    /**
     * 默认服务提供者
     *
     * @var array
     */
    protected $defaultProviders = [
        StockProvider::class,
        EcommerceProvider::class,
    ];

    /**
     * @return Stock
     */
    public function busifavor()
    {
        return $this->offsetGet('busifavor_stock');
    }

    /**
     * @return Stock
     */
    public function ecommerce()
    {
        return $this->offsetGet('ecommerce');
    }

}