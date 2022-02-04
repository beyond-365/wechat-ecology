<?php

return [
    'host' => 'https://apis.map.qq.com/',

    'http' => [
        'timeout'      => 3.0,
        'debug'        => false,
        'logging'      => true,
        'log_template' => '{"sdk_uri":"{uri}","code":"{code}","request":"{req_body}","body":"{res_body}","error":"{error}"}'
    ],
    // 微信支付凭证
    'we_chat_pay' => [
        'merchant_id'                 => '商户号', //商户号
        'merchant_serial_number'      => '商户API证书序列号', // 商户API证书序列号
        'merchant_private_key_path'   => '商户私钥路径', // 商户私钥路径
        'wechat_pay_certificate_path' => '微信支付平台证书路径', // 微信支付平台证书路径
    ],
];
