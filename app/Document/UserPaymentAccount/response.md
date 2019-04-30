# 金流帳號

> 獲取可用金流帳號(商戶角色用)

```
{
  "code": 200,
  "data": [
    {
      "id": 10,
      "name": "quickPass",
      "vendor": "QuickPassPayeeQRCode",
      "conn_config": {
        "account": "test",
        "qr_code_url": "http://www.google.com.tw"
      }
    },
    {
      "id": 11,
      "name": "Q2",
      "vendor": "weChatPayeeQRCode",
      "conn_config": {
        "account": "happy",
        "qr_code_url": "http://www.google.com.tw"
      }
    }
  ]
}
```
# 金流帳號

> 獲取可用金流帳號(商戶角色用)

```
{
  "code": 200,
  "data": [
    {
      "id": 2,
      "vendor": "aliPay",
      "conn_config": {
        "app_id": "22222",
        "app_public_key": "22222",
        "private_key": "222222"
      }
    },
    {
      "id": 3,
      "vendor": "weChatPay",
      "conn_config": {
        "app_id": "123",
        "mch_id": "123",
        "private_key": "123"
      }
    }
  ]
}
```
