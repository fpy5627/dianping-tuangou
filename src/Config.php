<?php

namespace Fpy\TuanGou;


class Config
{
    public $app_key;

    public $app_secret;

    public $v = 1;

    public $sign_method = 'MD5';

    public $format = 'json';

    public function __construct($appKey, $appSecret)
    {
        $this->app_key = $appKey;
        $this->app_secret = $appSecret;
    }

    /**
     * build common params for tuangou api
     * @Interface commonParams
     * @return mixed
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:26
     */
    public function commonParams($session)
    {
        $data['app_key'] = $this->app_key;
        $data['timestamp'] = date('Y-m-d H:i:s' , time());
        $data['session'] = $session;
        $data['format'] = $this->format;
        $data['v'] = $this->v;
        $data['sign_method'] = $this->sign_method;

        return $data;
    }
}
