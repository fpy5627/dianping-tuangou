<?php
namespace Fpy\TuanGou;

use Fpy\TuanGou\Config as TGconfig;
use Fpy\TuanGou\Server as TGserver;

class TuanGou
{
    protected $config;

    public function __construct($appKey, $appSecret)
    {
        $this->config = new TGconfig($appKey, $appSecret);
    }

    /**
     * 输码验券校验接口
     * @Interface prepare
     * @param $receiptCode
     * @param $openShopUuid
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午1:55
     */
    public function prepare($receiptCode, $openShopUuid, $session)
    {
        $uri = '/router/tuangou/receipt/prepare';
        $commonParams = $this->config->commonParams($session);
        $params['receipt_code'] = $receiptCode;
        $params['open_shop_uuid'] = $openShopUuid;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 扫码验券校验接口
     * @Interface scanPrepare
     * @param $receiptCode
     * @param $openShopUuid
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午1:56
     */
    public function scanPrepare($receiptCode, $openShopUuid, $session)
    {
        $uri = '/router/tuangou/receipt/scanprepare';
        $commonParams = $this->config->commonParams($session);
        $params['qr_code'] = $receiptCode;
        $params['open_shop_uuid'] = $openShopUuid;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 验券接口
     * @Interface consume
     * @param $requestId
     * @param $code
     * @param $count
     * @param $openShopUuid
     * @param $shopAccount
     * @param $shopAccountName
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午2:17
     */
    public function consume($requestId, $code, $count, $openShopUuid, $session, $shopAccount, $shopAccountName)
    {
        $uri = '/router/tuangou/receipt/consume';
        $commonParams = $this->config->commonParams($session);
        $params['requestid'] = $requestId;
        $params['receipt_code'] = $code;
        $params['count'] = $count;
        $params['open_shop_uuid'] = $openShopUuid;
        $params['app_shop_account'] = $shopAccount;
        $params['app_shop_accountname'] = $shopAccountName;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 查询已验券信息接口
     * @Interface getConsumed
     * @param $code
     * @param $openShopUuid
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午2:48
     */
    public function getConsumed($code, $openShopUuid, $session)
    {
        $uri = '/router/tuangou/receipt/getconsumed';
        $commonParams = $this->config->commonParams($session);
        $params['receipt_code'] = $code;
        $params['open_shop_uuid'] = $openShopUuid;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 验券记录
     * @Interface consumeHistory
     * @param $date
     * @param $openShopUuid
     * @param $session
     * @param int $type
     * @param null $bizType
     * @param int $pageIndex
     * @param int $pageSize
     * @return mixed
     * @author: fangpengyu
     * @Time: 19-1-21 下午8:34
     */
    public function consumeHistory($date, $openShopUuid, $session, $type=0, $bizType=null, $pageIndex=1, $pageSize=10)
    {
        $uri = '/router/tuangou/receipt/querylistbydate';
        $commonParams = $this->config->commonParams($session);
        $params['date'] = $date;
        $params['open_shop_uuid'] = $openShopUuid;
        $params['type'] = $type;
        $params['biz_type'] = $bizType;
        $params['offset'] = $pageIndex;
        $params['limit'] = $pageSize;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 撤销验券接口
     * @Interface reverseConsume
     * @param $appDealId
     * @param $code
     * @param $openShopUuid
     * @param $shopAccount
     * @param $shopAccountName
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:04
     */
    public function reverseConsume($appDealId, $code, $openShopUuid, $session, $shopAccount, $shopAccountName)
    {
        $uri = '/router/tuangou/receipt/reverseconsume';
        $commonParams = $this->config->commonParams($session);
        $params['app_deal_id'] = $appDealId;
        $params['receipt_code'] = $code;
        $params['open_shop_uuid'] = $openShopUuid;
        $params['app_shop_account'] = $shopAccount;
        $params['app_shop_accountname'] = $shopAccountName;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('POST', $uri,['form_params'=>$params]);
    }

    /**
     * 获取团购信息接口
     * @Interface queryShopDeal
     * @param $openShopUuid
     * @param int $pageIndex
     * @param int $pageSize
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @author: fangpengyu
     * @Time: 19-1-21 下午3:05
     */
    public function queryShopDeal($openShopUuid, $session, $pageIndex=1, $pageSize=10)
    {
        $uri = '/tuangou/deal/queryshopdeal';
        $commonParams = $this->config->commonParams($session);
        $params['open_shop_uuid'] = $openShopUuid;
        $params['offset'] = $pageIndex;
        $params['limit'] = $pageSize;
        $params = array_merge($params,$commonParams);
        $params = array_filter($params);
        $server = new TGserver();
        $sign = $server->buildSign($params,$this->config->app_secret);
        $params['sign'] = $sign;

        return $server->sendRequest('GET', $uri,['query'=>$params]);
    }
}
