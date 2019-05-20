# 監聽設置-銀行簡訊範本

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template|      |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | bank_id                     |  int         |              |      銀行id         |   x  |
|             | status                      |  string      |      Y       |   啟用狀態(N or Y)    |  x  |
|             | page                        | int          |      1       |   分頁(預設值1,最小值:1)|   x  |
|             | perpage                     | int          |      20      |   每頁筆數(1~100)      |   x  |

> 列表筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template/total|      |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | bank_id                     |  int         |              |      銀行id         |   x  |
|             | status                      |  string      |      Y       |   啟用狀態(N or Y)    |  x  |

> 單筆資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template/{id}| |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |  int         |              |      簡訊範本id       |   O  |


> 新增/更新

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template/edit| |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                          |  int         |              |  簡訊範本id,更新時為必填|   x  |
|             | bank_id                     |  int         |              |      銀行id          |   O  |
|             | contents                    |  string      |              |      範本內文         |   O  |
|             | status                      |  string      |              |      啟用狀態(N or Y) |   O  |


> 前台-取得簡訊範本

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template/front|      |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | bank_id                     |  int         |              |      銀行id          |   x  |
|             | refresh                     | Y-m-d H:i:s  |              |    刷新時間           |  x  |


> 搜尋選項

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |company/listener/setting/bank/template/search/options|     |              |                     |      |
| <b>方法</b>  | GET                         |              |              |                     |      |
| <b>權限</b>  |listener.setting.bankTemplate|              |              |          -          |      |
