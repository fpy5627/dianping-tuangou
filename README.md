<h1 align="center"> tuangou </h1>

<p align="center"> sdk of dianping/tuangou.</p>
<p align="center"> 北极星开放平台,美团api接口SDK</p>


## Installing

```shell
$ composer require fpy/tuangou
```

## Usage

只有团购的api,以及自用型应用、工具型应用授权,新版接口不推荐使用app_shop_id,因此本sdk只使用open_shop_uuid

### 授权
```php
use Fpy\TuanGou\TuanGou;
$tuangou = new TuanGou($appKey, $appSecret);
```
商家通过接入授权UI，可获取到对应的auth_code，通过此接口获取此次发起授权的session。

- session换取接口/getToken($authCode, $redirectUrl=null)
- session刷新接口/refreshToken($refreshToken)
- session范围查询接口/sessionQuery($session)
- session适用店铺查询接口/getScope($bid, $session)

### 团购
```php
use Fpy\TuanGou\Session;
$tuangou = new Session($appKey, $appSecret);
```


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/fpy/tuangou/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/fpy/tuangou/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT