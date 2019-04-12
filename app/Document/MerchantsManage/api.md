# 商戶功能 > 商戶管理

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | merchants.view        |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | status                 | string          |         |     帳號狀態(on:啟用/off:停用)        |   x  |
|             | apply_status                        | string          |         |     下發申請狀態(on:啟用/off:停用) |   x  |
|             | keyword                        | string          |         |  查詢條件(公司名稱完整比對) |   x  |
|             | page                        | int          |   1      |      分頁(預設值1,最小值:1)|   x  |
|             | perpage                     | int          |          |      每頁筆數(1~100)      |   x  |

> 列表總數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/total        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | merchants.view         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | status                 | string          |         |     帳號狀態(on:啟用/off:停用)        |   x  |
|             | apply_status                        | string          |         |    下發狀態(on:啟用/off:停用) |   x  |
|             | keyword                        | string          |         |  查詢條件(公司名稱完整比對) |   x  |

> 更新下發狀態

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/maintain/applyStatus        |              |              |                     |      |
| <b>方法</b>  | PUT                        |              |              |                     |      |
| <b>權限</b>  | merchants.view     |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |         |     帳號id        |   O  |
|             | apply_status                        | string          |         |     下發狀態(on:啟用/off:停用) |  O  |

> 商戶明細

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/maintain/{id}        |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | merchants         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |         |     帳號id        | O  |

> 新增商戶

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/maintain        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | merchants         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | company_name                 | string          |         |     公司名稱        | O  |
|             | mobile                 | string          |         |     手機號碼        | O  |
|             | email                 | string          |         |     信箱        | O  |
|             | status                 | string        |         |     帳號狀態(on:啟用/off:停用)   | O  |
|             | apply_status                 | string    |         |     下發狀態(on:啟用/off:停用)        | O  |
|             | QQ_id                 | string    |         |     QQ id        | O  |
|             | password                 | string    |         |     密碼        | O  |
|             | secret_code                 | string    |         |     安全碼        | O  |

> 更新商戶

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/maintain        |              |              |                     |      |
| <b>方法</b>  | PUT                        |              |              |                     |      |
| <b>權限</b>  | merchants         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |         |     帳號id        | O  |
|             | company_name                 | string          |         |     公司名稱        | O  |
|             | mobile                 | string          |         |     手機號碼        | O  |
|             | email                 | string          |         |     信箱        | O  |
|             | status                 | string        |         |     帳號狀態(on:啟用/off:停用)   | O  |
|             | apply_status                 | string    |         |     下發狀態(on:啟用/off:停用)        | O  |
|             | QQ_id                 | string    |         |     QQ id        | O  |
|             | password                 | string    |         |     密碼        | X  |
|             | secret_code                 | string    |         |     安全碼        | X  |

> 刪除商戶

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/merchants/maintain        |              |              |                     |      |
| <b>方法</b>  | DELETE                        |              |              |                     |      |
| <b>權限</b>  | merchants         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |         |     帳號id        | O  |
