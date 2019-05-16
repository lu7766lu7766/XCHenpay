# 系統設置 > 金流管理

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/dataList|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | keyword                     |  string      |              |      搜尋關鍵字(fuzzy search payment name )          |   x  |
|             | status                      |  string      |              |      (on or off)          |   x  |
|             | page                        |  int         |       1      | 分頁(預設值1,最小值:1) |   x  |
|             | perpage                     |  int         |       10     |      每頁筆數(1~100)  |   x  |

> 總數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/dataTotal|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | keyword                     |  string      |              |      搜尋關鍵字(fuzzy search payment name )          |   x  |
|             | status                      |  string      |              |      狀態(on or off)          |   x  |

> 單筆資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/detail|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |  int         |              |                      |   o  |

> 新增

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/add|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | name                        |  string      |              |                      |   o  |
|             | status                      |  string      |      on        |      狀態(on or off)          |   x  |
|             | min_deposit                 |  integer      |              |      最小儲值金額          |   o  |
|             | max_deposit                 |  integer      |              |      最大儲值金額          |   o  |
|             | total_deposit               |  integer      |              |      總儲值金額          |   o  |
|             | deposit_type               |  integer      |              |      結算方式(daily or week or monthly)          |   x  |
|             | withdraw                   |  integer      |              |      提款金額          |   o  |
|             | vendor                   |  string      |              |      金流來源          |   o  |
|             | conn_config                   |  array      |              |      各支付設定,詳情請參照下方conn_config_payload          |   o  |

> 更新

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/update|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                        |  integer      |              |                      |   o  |
|             | name                        |  string      |              |                      |   o  |
|             | status                      |  string      |       on       |      狀態(on or off)          |   x  |
|             | min_deposit                 |  integer      |              |      最小儲值金額          |   o  |
|             | max_deposit                 |  integer      |              |      最大儲值金額          |   o  |
|             | total_deposit               |  integer      |              |      總儲值金額          |   o  |
|             | deposit_type               |  integer      |              |      結算方式(daily or week or monthly)          |   x  |
|             | withdraw                   |  integer      |              |      提款金額          |   o  |
|             | vendor                   |  string      |              |      金流來源          |   o  |
|             | conn_config                   |  array      |              |      各支付設定,詳情請參照下方conn_config_payload          |   o  |


> 刪除

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/del|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                        |  integer      |              |                      |   o  |

> 金流來源清單

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/payment/manage/source|              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | payment.manage            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |

> vendor

| 代碼 |  說明 |
|-----|------|
| aliPay    |  支付寶  |    
| weChatPay    |  微信支付|   
| unionPay   |  聯銀  |    
| qqPay   |  QQ  |   
| aliPayRedEnvelop   |  支付寶紅包  |
| aliPayPersonalBankAccount   |  支付寶收款  |   

>conn_config_payload

| 代碼 |  參數 |  類型 |  說明 |
|-----|------|------|------|
| aliPay   |  app_id  |    string  |      應用ID  |
| aliPay   |  app_public_key  |    string  |      公開鑰匙  |
| aliPay   |  private_key  |    string  |      私鑰  |
| weChatPay   |  app_id  |    string  |      應用ID  |
| weChatPay   |  mch_id  |    string  |      商戶ID  |
| weChatPay   |  private_key  |    string  |      私鑰  |
| unionPay   |  mch_id  |    string  |      商戶ID  |
| unionPay   |  cert_pwd  |    string  |      證書密碼  |
| unionPay   |  cert_path  |    string  |      證書路徑  |
| unionPay   |  app_url  |    string  |      APP URL  |
| qqPay   |  mch_id  |    string  |      商戶ID  |
| qqPay   |  private_key  |    string  |      私鑰  |
| qqPay   |  cert_path  |    string  |      證書路徑  |
| aliPayRedEnvelop   |  ali_pay_account  |    string  |      支付寶帳號  |
| aliPayRedEnvelop   |  pid  |    string  |      開發者ID  |
| aliPayPersonalBankAccount   |  ali_pay_account  |    string  |      支付寶帳號  | 
| aliPayPersonalBankAccount   |  qr_code_url  |    string  |      qrCode解析後的網址  |
| aliPayPersonalBankAccount   |  qr_code_url_time  |    string  |      qrCode解析後時間  |  
| weChatPayeeQRCode   |  account  |    string  |      微信帳號  | 
| weChatPayeeQRCode   |  qr_code_url  |    string  |      qrCode解析後的網址  | 
| weChatPayeeQRCode   |  qr_code_url_time  |    string  |      qrCode解析後時間  |
| QuickPassPayeeQRCode   |  account  |    string  |      雲閃付帳號  | 
| QuickPassPayeeQRCode   |  qr_code_url  |    string  |      qrCode解析後的網址  |
| QuickPassPayeeQRCode   |  qr_code_url_time  |    string  |      qrCode解析後時間  |
| aliPayPersonPayee   |  ali_pay_account  |    string  |      支付寶帳號  |  
| aliPayPersonPayee   |  pid  |    string  |      開發者ID  |
| aliPayTransferOut   |  ali_pay_account  |    string  |      支付寶帳號  |  
| aliPayTransferOut   |  pid  |    string  |      開發者ID  |        
