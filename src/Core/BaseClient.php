<?php


namespace Beyond\WeChatEcology\Core;

use Beyond\SmartHttp\Kernel\BaseClient as Client;
use Beyond\SmartHttp\Kernel\Exceptions\AuthorizationException;
use Beyond\SmartHttp\Kernel\Exceptions\BadRequestException;
use Beyond\SmartHttp\Kernel\Exceptions\ResourceNotFoundException;
use Beyond\SmartHttp\Kernel\Exceptions\ServiceInvalidException;
use Beyond\SmartHttp\Kernel\Exceptions\ValidationException;
use Beyond\SmartHttp\Kernel\ServiceContainer;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class BaseClient extends Client
{

    /**
     * BaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        if ($host = $app->offsetGet('config')->get('host', '')) {
            $this->setBaseUri($host);
        }

        parent::__construct($app);
    }

    /**
     * 处理请求异常 request
     *
     * @param $url
     * @param string $method
     * @param array $options
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function request($url, $method = 'POST', array $options = [])
    {
        try {
            $response =  parent::request($url, $method, $options);
            return $this->unwrapResponse($response);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $contents = $response->getBody()->getContents();
            $content = json_decode($contents);

            $code = property_exists($content, 'code') && is_int($content->code) ? $content->code : 100001;
            $message = property_exists($content, 'message') ? $content->message : '';
            !is_numeric($content->code) && $message = sprintf('%s:%s', $content->code, $message);

            switch ($statusCode) {
                case 404:
                    throw new ResourceNotFoundException($message, $code);
                case 400:
                case 422:
                    throw new ValidationException($message, $code);
                    break;
                case 401:
                    throw new AuthorizationException($message, $code);
                default:
                    throw new ServiceInvalidException($message ? $message : 'Service Invalid', $code);
            }
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            $content = json_decode($contents);
            $message = property_exists($content, 'message') ? $content->message : 'Service Invalid';
            $code = property_exists($content, 'code') ? $content->code : 100000;

            throw new ServiceInvalidException($message, $code);
        } catch (RequestException $e) {
            // 在发送网络错误(连接超时、DNS错误等)时
            throw new BadRequestException($e->getMessage(), 400);
        }
    }

    /**
     * 发送表单上传附件
     *
     * @param $url
     * @param array $files
     * @param array $form
     * @param array $query
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpUpload($url, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];

        foreach ($files as $name => $file) {
            $multipart [] = [
                'name' => $name,
                'contents' => $file,
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request($url, 'POST', compact('multipart', 'query'));
    }

    /**
     * 发送 PATCH JSON 请求
     *
     * @param $url
     * @param array $data
     * @param array $query
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpPatchJson($url, array $data = [], array $query = [])
    {
        $data = empty($data) ? new \stdClass() : $data;

        return $this->request($url, 'PATCH', ['query' => $query, 'json' => $data]);
    }

    /**
     * 发送 PUT JSON 请求
     *
     * @param $url
     * @param array $data
     * @param array $query
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpPutJson($url, array $data = [], array $query = [])
    {
        $data = empty($data) ? new \stdClass() : $data;

        return $this->request($url, 'PUT', $this->formatOptions($data, $query));
    }

    /**
     * 发送表单数据（application/x-www-form-urlencoded）
     *
     * @param $url
     * @param array $data
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpPost($url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * @param $url
     * @param array $query
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpGet($url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param $url
     * @param array $data
     * @param array $query
     * @return array|string
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function httpPostJson($url, array $data = [], array $query = [])
    {
        $data = empty($data) ? new \stdClass() : $data;

        return $this->request($url, 'POST', $this->formatOptions($data, $query));
    }

    /**
     * 格式化 option
     *
     * @param $data
     * @param array $query
     * @return array
     */
    private function formatOptions($data, $query = [])
    {
        return empty($query) ? ['json' => $data] : ['query' => $query, 'json' => $data];
    }
}
