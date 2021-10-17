<?php


namespace Beyond\WeChatEcology;

use Beyond\SmartHttp\Application as BaseApplication;
use Beyond\WeChatEcology\Marketing\Busifavor\Stock;
use Beyond\WeChatEcology\Marketing\Busifavor\StockProvider;


class Application extends BaseApplication
{
    protected $defaultProviders = [
        StockProvider::class,
    ];

    /**
     * @return Stock
     */
    public function busifavor()
    {
        return $this->offsetGet('busifavor_stock');
    }

}