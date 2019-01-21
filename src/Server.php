<?php

namespace Fpy\TuanGou;

use Fpy\TuanGou\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;

class Server
{
    /**
     * 获取签名
     * @Interface buildSign
     * @param $params
     * @param $secret
     * @return string
     * @throws InvalidArgumentException
     * @author: fangpengyu
     * @Time: 19-1-21 下午4:02
     */
    public function buildSign($params,$secret)
    {
        $str = '';
        ksort($params);
        foreach ($params as $k => $v) {
            if ($v == null) {
                throw new InvalidArgumentException('Invalid params key:'.$k);
            }
            $str .= $k.$v;
            unset($k,$v);
        }
        $str = $secret.$str.$secret;
        return strtolower(md5($str));
    }

    public function sendRequest($method, $uri, $params)
    {
        $client = new Client(['base_uri' => 'https://openapi.dianping.com']);
        $response = $client->request($method, $uri,$params);
        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }
}
