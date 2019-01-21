<?php
namespace Fpy\TuanGou;

use Fpy\TuanGou\Config as TGconfig;
use Fpy\TuanGou\Server as TGserver;

class Session
{
    protected $config;

    private $grant_type = 'authorization_code';

    public function __construct($appKey,$appSecret)
    {
        $this->config = new TGconfig($appKey, $appSecret);
    }

    /**
     * session换取接口
     * @Interface getToken
     * @param string $authCode
     * @param string $redirectUrl
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-19 下午6:36
     */
    public function getToken($authCode, $redirectUrl=null)
    {
        $uri = '/router/oauth/token';
        $params['auth_code'] = $authCode;
        $params['app_key'] = $this->config->app_key;
        $params['app_secret'] = $this->config->app_secret;
        $params['grant_type'] = $this->grant_type;
        $params['redirect_url'] = $redirectUrl;
        $params = array_filter($params);
        $server = new TGserver();
        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * session刷新接口
     * @Interface refreshToken
     * @param $refreshToken
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:49
     */
    public function refreshToken($refreshToken)
    {
        $uri = '/router/oauth/token';
        $params['app_key'] = $this->config->app_key;
        $params['app_secret'] = $this->config->app_secret;
        $params['grant_type'] = $this->grant_type;
        $params['refresh_token'] = $refreshToken;
        $server = new TGserver();

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * session范围查询接口
     * @Interface sessionQuery
     * @param $session
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:49
     */
    public function sessionQuery($session)
    {
        $uri = '/router/oauth/session/query';
        $params = $this->config->commonParams($session);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('GET', $uri,['query'=>$params]);
    }

    /**
     * session适用店铺查询接口
     * @Interface getScope
     * @param $bid
     * @param $session
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:50
     */
    public function getScope($bid, $session)
    {
        $uri = '/router/oauth/session/scope';
        $params = $this->config->commonParams($session);
        $params['bid'] = $bid;
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('GET', $uri,['query'=>$params]);
    }
}
