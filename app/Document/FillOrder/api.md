# 補單管理

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/order/fill/index       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | fill_order                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                       |  Y-m-d H:i:s |              |        起始日        |   o  |
|             | end                         |  Y-m-d H:i:s |              |        結束日        |   o  |
|             | company_service_id          | string       |              |         商戶id       |   x  |
|             | payment                     | int          |              |   支付方式(i6pay_id)  |   x  |
|             | pay_state                   | int          |              |         支付狀態(表1)      |   x  |
|             | keyword                     | string       |              |         關鍵字       |   x  |
|             | page                        | int          |      1       |         分頁         |   x  |
|             | perpage                     | int          |      20      |         每頁筆數      |   x  |

> 總筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/order/fill/total       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | fill_order                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                       |  Y-m-d H:i:s |              |        起始日        |   o  |
|             | end                         |  Y-m-d H:i:s |              |        結束日        |   o  |
|             | company_service_id          | string       |              |         商戶id       |   x  |
|             | payment                     | int          |              |   支付方式(i6pay_id)  |   x  |
|             | pay_state                   | int          |              |         支付狀態(表1)      |   x  |
|             | keyword                     | string       |              |         關鍵字       |   x  |

> 編輯

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/order/fill/edit       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | fill_order                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          | int          |              | order_id,編輯時請填寫要編輯的id       |   x  |
|             | user_id                  |  int |              |        帳號流水號(user_id)        |   o  |
|             | payment                     | int          |              |   支付方式(i6pay_id)  |   o  |
|             | pay_state                   | int          |              |         支付狀態(表1)      |   o  |
|             | amount                    |  float |              |        金額        |   o  |
|             | fee          | float       |              |         手續費       |   o  |
|             | pay_time                     | Y-m-d H:i:s       |              |         交易日期       |   o  |
|             | trade_service_id                     | string       |              |         商戶交易號       |   x  |
|             | remark                     | string       |              |         備註       |   x  |

> 單筆查詢

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/order/fill/info/{id}       |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | fill_order                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          | int          |              | order_id       |   o  |

> 查詢/新增/編輯 選項

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/order/fill/option       |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | fill_order                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |

> 表1

| 項目         |  說明 |
|-------------|------|
| 0  |  申请成功    |   
| 1  |  交易中    |    
| 2  |  交易成功,未回调    |   
| 3  |  交易结束    |    
| 4  |  交易失败    |   