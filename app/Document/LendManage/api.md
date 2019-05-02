# 商戶功能 > 下發管理

### 後台API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage             |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | user_id                      | int         |              |          商戶ID      |   x  |
|             | start_date                   | string      |              |        Y-m-d H:i:s  |   x  |
|             | end_date                     | string      |              |        Y-m-d H:i:s  |   x  |
|             | page                         | int         |      1      |         分頁(預設值1,最小值:1)     |   x  |
|             | perpage                      | int         |      10      |         每頁筆數(1~100)     |   x  |
|             | lend_state                   | string      |            |          (0=>下發中,1=>完成下發,2=>拒绝下发)    |   x  |
|             | keyword                      | string      |            |          搜尋關鍵字(fuzzy search record_seq or account )    |   x  |
|             | sort                         | string      |      created_at     |          依照甚麼排序    |   x  |
|             | direction                    | string      |      desc     |          排序    |   x  |

> 總筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage/dataTotal             |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | user_id                      | int         |              |          商戶ID      |   x  |
|             | start_date                   | string      |              |        Y-m-d H:i:s  |   x  |
|             | end_date                     | string      |              |        Y-m-d H:i:s  |   x  |
|             | lend_state                   | string      |            |          (0=>下發中,1=>完成下發,2=>拒绝下发)    |   x  |
|             | keyword                      | string      |            |          搜尋關鍵字(fuzzy search record_seq or account )    |   x  |

> 申請列表小計與總計金額

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage/total             |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | user_id                      | int         |              |          商戶ID      |   o  |

> 更新

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage/total             |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                      | int         |              |                |   o  |
|             | operation                      | string     |              |    (0=>下發中,1=>完成下發,2=>拒绝下发)     |   o  |
|             | note                      | string     |              |    備註    |   x  |

> 下發中總數量

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage/applyNotice             |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |

> 下發狀態及商戶資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/lendManage/data             |              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | 非商戶腳色                    |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |