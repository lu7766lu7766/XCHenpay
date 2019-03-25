# 收款管理 > 公司帳戶

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | company.account            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | search                      | string      |              |        搜尋關鍵字(fuzzy search card_no or user_name )        |   x  |
|             | status                      | string      |              |        啟用狀態(N or Y)        |   x  |
|             | page                        | int          |      1       |         分頁(預設值1,最小值:1)         |   x  |
|             | perpage                     | int          |      20      |         每頁筆數(1~100)      |   x  |

> 總筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company/total       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | company.account                  |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | search          | string    |              |   搜尋關鍵字(fuzzy search card_no or user_name )       |   x  |
|             | status          | string    |              |   啟用狀態(N or Y)        |   x  |

> 新增

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company/create |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | company.account            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | card_id                     |    string    |              |   隐藏银行卡号使用, 若无输入, 则无法隐藏银行卡号 | x  |
|             | user_name                   |    string    |              |   開戶名              |   o  |
|             | card_no                     |    string    |              |   銀行卡號            |   o  |
|             | bank_name                   |    string    |              |   銀行名              |   o  |
|             | channel                     |    string    |              |   通道類型            |   o  |
|             | status                      |    string    |      Y       |   啟用狀態(N or Y)    |   o  |
|             | minimum_amount              |      int     |              |   最低儲值            |   o  |
|             | maximum_amount              |      int     |              |   最高儲值            |   o  |
|             | total_amount                |      int     |              |   總儲值金額          |   o  |
|             | statistics_type             |    string    |              |   計算類型(day,week,month)|   o  |

> 更新

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company        |              |              |                     |      |
| <b>方法</b>  | PUT                         |              |              |                     |      |
| <b>權限</b>  | company.account            |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |      int     |              |   帳戶id             |   o  |
|             | card_id                     |    string    |              |   隐藏银行卡号使用, 若无输入, 则无法隐藏银行卡号 | x  |
|             | status                      |    string    |      Y       |   啟用狀態(N or Y)    |   o  |
|             | minimum_amount              |      int     |              |   最低儲值            |   o  |
|             | maximum_amount              |      int     |              |   最高儲值            |   o  |
|             | total_amount                |      int     |              |   總儲值金額          |   o  |
|             | statistics_type             |    string    |              |   計算類型(day,week,month)|   o  |

> 單筆資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company/{id}/info       |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | company.account                   |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          | int          |              | 收款的帳戶流水號       |   o  |

> 取得通道類型

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company/channel       |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | company.account                   |              |              |          -          |      |

> 取得狀態

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/cashier/company/status       |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | company.account                   |              |              |          -          |      |
