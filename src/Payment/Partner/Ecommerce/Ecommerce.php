<?php


namespace Beyond\WeChatEcology\Payment\Partner\Ecommerce;

use Beyond\SmartHttp\Kernel\Exceptions\AuthorizationException;
use Beyond\SmartHttp\Kernel\Exceptions\BadRequestException;
use Beyond\SmartHttp\Kernel\Exceptions\InvalidArgumentException;
use Beyond\SmartHttp\Kernel\Exceptions\ResourceNotFoundException;
use Beyond\SmartHttp\Kernel\Exceptions\ServiceInvalidException;
use Beyond\SmartHttp\Kernel\Exceptions\ValidationException;

/**
 * 微信支付->服务商->收付通
 *
 * Class Ecommerce
 * @package Beyond\WeChatEcology\Payment\Partner\Ecommerce
 */
class Ecommerce extends EcommerceClient
{
    /**
     * 二级商户进件
     *
     * @param $params
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function applyment($params)
    {
        $this->httpPostJson('/v3/ecommerce/applyments/', $params);
    }

    /**
     * 查询申请状态
     *
     * @param $id
     * @param string $type
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function queryApplymentState($id, $type = 'applyment')
    {
        if ('applyment' == $type) {
            $format = '/v3/ecommerce/applyments/%s';
        } elseif ('request' == $type) {
            $format = '/v3/ecommerce/applyments/out-request-no/%s';
        } else {
            throw new InvalidArgumentException('type参数错误。支持:applyment,request', 200001);
        }

        $this->httpGet(sprintf($format, $id));
    }
}