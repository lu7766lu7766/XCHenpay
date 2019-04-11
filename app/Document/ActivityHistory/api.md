# 歷程記錄 > 帳戶歷程

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/activity_log/data       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |             |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                      | string      |              |      起始時間(Y-m-d H:i:s)        |   o  |
|             | end                      | string      |              |        結束時間(Y-m-d H:i:s)        |   o  |
|             | page                        | int          |      1       |         分頁(預設值1,最小值:1)         |   x  |
|             | perpage                     | int          |      20      |         每頁筆數(1~100)      |   x  |
|             | sort                        | string          |            |         排序(DESC or ASC)      |   o  |
|             | keyword                     | string          |           |         搜尋關鍵字(fuzzy search description )      |   x  |

> 總筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/activity_log/data/total       |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  |             |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | start                      | string      |              |      起始時間(Y-m-d H:i:s)        |   o  |
|             | end                      | string      |              |        結束時間(Y-m-d H:i:s)        |   o  |
|             | keyword                     | string          |           |         搜尋關鍵字(fuzzy search description )      |   x  |
