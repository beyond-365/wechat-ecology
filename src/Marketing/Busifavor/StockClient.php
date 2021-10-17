<?php


namespace Beyond\WeChatEcology\Marketing\Busifavor;


use Beyond\WeChatEcology\Core\BaseClient;

abstract class StockClient extends BaseClient
{
    public $baseUri = 'https://api.mch.weixin.qq.com/v3/marketing';

    public function unwrapResponse($response)
    {
        return $response;
    }
}
