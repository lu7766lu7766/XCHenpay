# 查詢功能 > 訂單查詢

### API

> 訂單資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/showInfo/{authcode} |              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | authcode                    |  int         |              |     訂單id           |   o  |

> 交易狀態修改頁面資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/showState/{authcode}|              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | logQuery.showState          |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | authcode                    |  int         |              |     訂單id           |   o  |

> 交易狀態修改

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/updateState         |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | logQuery.updateState        |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |  int         |              |     訂單id           |   o  |
|             | status                      |  int         |              |     訂單狀態          |   o  |
|             | real_paid_amount            |  int         |              |     實際支付金額       |   o  |


> 商戶注單總數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |dataTotal                    |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                       |  Y-m-d H:i:s |              |     起始日           |   o  |
|             | end                         |  Y-m-d H:i:s |              |     結束日           |   o  |
|             | page                        |   int        |      1       |     分頁             |   x  |
|             | perpage                     |   int        |      25      |     每頁筆數          |   x  |
|             | pay_state                   |  int         |              |     交易狀態(表1)     |   x  |
|             | payment_type                |  int         |              |     支付類型          |   x  |
|             | sort                        |  string      |  created_at  |     时间排序          |   x  |
|             | company                     |  int         |              |     商戶id           |   x  |
|             | keyword                     |  string      |              |     關鍵字查詢        |   x  |
|             | direction                   |  string      |   desc       |     排序(asc/desc)   |   x  |

> 訂單交易資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |orderTradeInfo               |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                       |  Y-m-d H:i:s |              |     起始日           |   o  |
|             | end                         |  Y-m-d H:i:s |              |     結束日           |   o  |
|             | pay_state                   |  int         |              |     交易狀態(表1)     |   x  |
|             | payment_type                |  int         |              |     支付類型          |   x  |
|             | company                     |  int         |              |     商戶id           |   x  |

> 訂單銀行卡資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |{id}/bankCardAccountInfo     |              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | bank_card_id                |  int         |              |     銀行卡id         |   o  |


> 支付方式列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/payment             |              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |


> 訂單列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |data                         |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                       |  Y-m-d H:i:s |              |     起始日           |   o  |
|             | end                         |  Y-m-d H:i:s |              |     結束日           |   o  |
|             | page                        |   int        |      1       |     分頁             |   x  |
|             | perpage                     |   int        |      25      |     每頁筆數          |   x  |
|             | pay_state                   |  int         |              |     交易狀態(表1)     |   x  |
|             | payment_type                |  int         |              |     支付類型          |   x  |
|             | sort                        |  string      |  created_at  |     时间排序          |   x  |
|             | company                     |  int         |              |     商戶id           |   x  |
|             | keyword                     |  string      |              |     關鍵字查詢        |   x  |
|             | direction                   |  string      |   desc       |     排序(asc/desc)   |   x  |

> 取得初始資料

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/dataInit            |              |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  | -                           |              |              |          -          |      |


> 回調通知

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |logQuery/callNotify          |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | logQuery.callNotify         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |  int         |              |     訂單id           |   o  |



> 表1

| 項目         |  說明 |
|-------------|------|
| 0  |  申请成功      |   
| 1  |  交易中        |    
| 2  |  交易成功,未回调 |   
| 3  |  交易结束       |    
| 4  |  交易失败       |   