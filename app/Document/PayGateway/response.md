# 支付通道

> 支轉銀頁面資訊

```
{
   "code": 200,
    "data": {
      "order_number": "abc123as45678f9g",
      "amount": 1,
      "expired_time": "2019-03-20 15:25:10",
      "qrcode_url": "alipays:\/\/platformapi\/startapp?appId=09999988&actionType=toCard&sourceId=bill&bankAccount=11&money=0.97&amount=0.97&bankMark=ICBC&bankName=11&cardNoHidden=1&cardChannel=HISTORY_CARD&orderSource=from&cardNo=%2A%2A&cardIndex=testID"
    }
}
```

> 喚起支付寶URL

```
{
     "code": 200,
     "data": "https://ds.alipay.com/?from=mobilecodec&scheme=alipays%3A%2F%2Fplatformapi%2Fstartapp%3FsaId%3D10000007%26clientVersion%3D3.7.0.0718%26qrcode%3Dhttp%253A%252F%252F0e866c8c.ngrok.io%252Fpay%252Fgateway%252Fto_bank_card%253Ftrade_seq%253D65623a3841a8f5fce30bacbac155c0e0%2526wait%253D60"
}
```

> 喚起掏寶URL

```
{
    "code": 200,
    "data": "taobao://render.alipay.com/p/s/i?scheme=https://ds.alipay.com/?from=mobilecodec&scheme=alipays%3A%2F%2Fplatformapi%2Fstartapp%3FsaId%3D10000007%26clientVersion%3D3.7.0.0718%26qrcode%3Dhttp%253A%252F%252F0e866c8c.ngrok.io%252Fpay%252Fgateway%252Fto_bank_card%253Ftrade_seq%253D65623a3841a8f5fce30bacbac155c0e0"
}
```
