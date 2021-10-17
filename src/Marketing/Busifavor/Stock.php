<?php


namespace Beyond\WeChatEcology\Marketing\Busifavor;

use Beyond\SmartHttp\Kernel\Exceptions\AuthorizationException;
use Beyond\SmartHttp\Kernel\Exceptions\BadRequestException;
use Beyond\SmartHttp\Kernel\Exceptions\ResourceNotFoundException;
use Beyond\SmartHttp\Kernel\Exceptions\ServiceInvalidException;
use Beyond\SmartHttp\Kernel\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface;

/**
 * 商家券
 *
 * Class Stock
 * @package Beyond\WeChatEcology\Marketing\Busifavor
 */
class Stock extends StockClient
{
    /**
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function create($data)
    {
        return $this->httpPostJson('/busifavor/stocks', $data);
    }

    /**
     * 上传预存code
     *
     * @param $stockId
     * @return ResponseInterface
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function preCouponCodes($stockId)
    {
        return $this->httpPost("/stocks/{$stockId}/couponcodes");
    }

    /**
     * 设置商家券事件通知地址API
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function setCallback($data)
    {
        return $this->httpPostJson('/busifavor/callbacks', $data);
    }

    /**
     * 查询商家券事件通知地址API
     *
     * @param $mchId
     * @return ResponseInterface
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function getCallback($mchId)
    {
        return $this->httpGet('/busifavor/callbacks', ['mchid' => $mchId]);
    }

    /**
     * 申请退券
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function returnCoupon($data)
    {
        return $this->httpPostJson('busifavor/coupons/return', $data);
    }
}