<?php


namespace Beyond\WeChatEcology\Middleware\Payment;


use Beyond\WeChatEcology\Middleware\Contract\RequestMiddleware;
use Psr\Http\Message\RequestInterface;
use WechatPay\GuzzleMiddleware\Util\PemUtil;

/**
 * 微信支付中间件
 *
 * Class WeChatPayMiddleware
 * @package Beyond\WeChatEcology\Middleware
 */
class WeChatPayMiddleware extends RequestMiddleware
{

    /**
     * @inheritDoc
     */
    public static function getAccessName()
    {
        return 'wechatpay_middleware';
    }

    /**
     * @inheritDoc
     */
    public function getHeaderKey()
    {
        return 'wechatpay';
    }

    /**
     * @inheritDoc
     */
    public function getHeaderValue(RequestInterface $request)
    {
        $weChatPay = $this->app->offsetGet('config.wechat_pay');

        // 商户相关配置
        $merchantId = $weChatPay['merchant_id']; // 商户号
        $merchantSerialNumber = $weChatPay['merchant_serial_number']; // 商户API证书序列号
        $merchantPrivateKeyPath = $weChatPay['merchant_private_key_path']; // 商户私钥路径
        $weChatPayCertificatePath = $weChatPay['wechat_pay_certificate_path']; // 微信支付平台证书路径

        $merchantPrivateKey = PemUtil::loadPrivateKey($merchantPrivateKeyPath);
        // 微信支付平台配置
        $weChatPayCertificate = PemUtil::loadCertificate($weChatPayCertificatePath);

        // 构造一个WeChatPayMiddleware
        return WechatPayMiddleware::builder()
            ->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey)
            ->withWechatPay([$weChatPayCertificate])
            ->build();
    }
}
