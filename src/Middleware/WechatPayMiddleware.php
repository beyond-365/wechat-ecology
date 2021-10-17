<?php


namespace Beyond\WeChatEcology\Middleware;


use Beyond\WeChatEcology\Middleware\Contract\BeforeMiddleware;
use Psr\Http\Message\RequestInterface;
use WechatPay\GuzzleMiddleware\Util\PemUtil;

/**
 * 微信支付中间件
 *
 * Class WechatPayMiddleware
 * @package Beyond\WeChatEcology\Middleware
 */
class WechatPayMiddleware extends BeforeMiddleware
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
        $wechatchPay = $this->app->offsetGet('config.wechat_pay');

        // 商户相关配置
        $merchantId = $wechatchPay['merchant_id']; // 商户号
        $merchantSerialNumber = $wechatchPay['merchant_serial_number']; // 商户API证书序列号
        $merchantPrivateKeyPath = $wechatchPay['merchant_private_key_path']; // 商户私钥路径
        $wechatpayCertificatePath = $wechatchPay['wechat_pay_certificate_path']; // 微信支付平台证书路径

        $merchantPrivateKey = PemUtil::loadPrivateKey($merchantPrivateKeyPath);
        // 微信支付平台配置
        $wechatPayCertificate = PemUtil::loadCertificate($wechatpayCertificatePath);

        // 构造一个WechatPayMiddleware
        return WechatPayMiddleware::builder()
            ->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey)
            ->withWechatPay([$wechatPayCertificate])
            ->build();
    }
}
