<?php


namespace Beyond\WeChatEcology\Payment\Marketing\Busifavor;

use Beyond\SmartHttp\Kernel\Exceptions\AuthorizationException;
use Beyond\SmartHttp\Kernel\Exceptions\BadRequestException;
use Beyond\SmartHttp\Kernel\Exceptions\ResourceNotFoundException;
use Beyond\SmartHttp\Kernel\Exceptions\ServiceInvalidException;
use Beyond\SmartHttp\Kernel\Exceptions\ValidationException;


/**
 * 微信支付->营销->商家券
 *
 * Class Stock
 * @package Beyond\WeChatEcology\Payment\Marketing\Busifavor
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
        return $this->httpPostJson('/v3/marketing/busifavor/stocks', $data);
    }

    /**
     * 商户可通过该接口查询已创建的商家券批次详情信息
     *
     * @param $stockId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function queryByStockId($stockId)
    {
        return $this->httpGet(sprintf('/v3/marketing/busifavor/stocks/%s', $stockId));
    }

    /**
     * 核券
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function useCoupon($data)
    {
        return $this->httpPostJson('/v3/marketing/busifavor/coupons/use', $data);
    }

    /**
     * 商户自定义筛选条件（如创建商户号、归属商户号、发放商户号等），查询指定微信用户卡包中满足对应条件的所有商家券信息
     *
     * @param $openid
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function queryByOpenId($openid)
    {
        return $this->httpGet(sprintf('/v3/marketing/busifavor/users/%s/coupons', $openid));
    }

    /**
     * 查询用户单张券详情
     *
     * @param $openId
     * @param $couponCode
     * @param $appId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function queryByCouponCode($openId, $couponCode, $appId)
    {
        return $this->httpGet(sprintf('/v3/marketing/busifavor/users/%s/coupons/%s/appids/%s', $openId, $couponCode, $appId));
    }

    /**
     *
     * 上传预存code
     *
     * @param $stockId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function preCouponCodes($stockId)
    {
        return $this->httpPost("/v3/marketing/busifavor/stocks/{$stockId}/couponcodes");
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
        return $this->httpPostJson('/v3/marketing/busifavor/callbacks', $data);
    }

    /**
     * 查询商家券事件通知地址API
     *
     * @param $mchId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function getCallback($mchId)
    {
        return $this->httpGet('/v3/marketing/busifavor/callbacks', ['mchid' => $mchId]);
    }

    /**
     * 将有效态（未核销）的商家券与订单信息关联，用于后续参与摇奖&返佣激励等操作的统计
     *
     * 已为用户发券，且调用查询接口查到用户的券code、批次ID等信息
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function associate($data)
    {
        return $this->httpPostJson('/v3/marketing/busifavor/coupons/associate', $data);
    }

    /**
     * 取消商家券与订单信息的关联关系
     *
     * 已调用关联接口为券创建过关联关系
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function disassociate($data)
    {
        return $this->httpPostJson('/v3/marketing/busifavor/coupons/disassociate', $data);
    }

    /**
     * 商户可以通过该接口修改批次单天发放上限数量或者批次最大发放数量
     *
     * 已创建商家券批次，且修改时间位于有效期结束时间前
     *
     * @param $stockId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function modifyBudget($stockId)
    {
        return $this->httpPatchJson(sprintf('/v3/marketing/busifavor/stocks/%s/budget', $stockId));
    }

    /**
     * 商户可以通过该接口修改商家券基本信息
     *
     * 前置条件： 已创建商家券批次，且修改时间位于有效期结束时间前
     *
     * @param $stockId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function busifavor($stockId)
    {
        return $this->httpPatchJson(sprintf('/v3/marketing/busifavor/stocks/%s', $stockId));
    }

    /**
     * 申请退券
     *
     * 前置条件: 券的状态为USED
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

    /**
     * 商户可通过该接口将单张领取后未核销的券进行失效处理，券失效后无法再被核销
     *
     * 前置条件：券的状态为SENDED
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function deactivate($data)
    {
        return $this->httpPostJson('/v3/marketing/busifavor/coupons/deactivate', $data);
    }

    /**
     * 该API主要用于商户营销补贴场景，支持by单张券进行不同商户账户间的资金补差，从而提升财务结算、资金利用效率
     *
     * 前置条件：商家必须核销了商家券且发起了微信支付收款
     *
     * @param $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function subsidy($data)
    {
        return $this->httpPostJson('/v3/marketing/busifavor/subsidy/pay-receipts', $data);
    }

    /**
     * 查询商家券营销补差付款单详情
     *
     * @param $subsidyReceiptId
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function querySubsidy($subsidyReceiptId)
    {
        return $this->httpGet(sprintf('/v3/marketing/busifavor/subsidy/pay-receipts/%s', $subsidyReceiptId));
    }
}