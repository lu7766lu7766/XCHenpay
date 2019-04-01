# 系統設置 > 帳號管理

### API

> 列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/userList        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | status                 | string          |              |     狀態(on:開啟/off:關閉)       |   x  |
|             | keyword                 | string          |              |     關鍵字(模糊比對帳戶名稱與信箱)       |   x  |
|             | page                        | int          |      1       |      分頁(預設值1,最小值:1)|   x  |
|             | perpage                     | int          |      25      |      每頁筆數(1~100,預設值10)      |   x  |

> 總筆數

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/total        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | status                 | string          |              |     狀態(on:開啟/off:關閉)       |   x  |
|             | keyword                 | string          |              |     關鍵字(模糊比對帳戶名稱與信箱)       |   x  |

> 單筆詳細資訊

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/userDetail        |              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |              |     帳號id(流水號)      |   o  |


> 角色列表

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/getRolesList|              |              |                     |      |
| <b>方法</b>  | GET                        |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |

> 新增

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/userAdd     |              |              |                     |      |
| <b>方法</b>  | POST                     |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
| <b>參數</b>  |                            |              |              |                     |      |
|             | company_name                         | string          |              |         長度1~50       |   O  |
|             | email                         | string          |              |         email格式       |   O  |
|             | status                 | string          |              |     狀態(on:開啟/off:關閉)       |   O  |
|             | password                         | string          |              |         密碼,長度4~16       |   O  |
|             | password_confirmation                         | string          |              |         密碼確認       |   O  |
|             | role_id                         | int          |              |         角色id(流水號)       |   O  |

> 修改

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/userUpdate|              |              |                     |      |
| <b>方法</b>  | POST                        |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
| <b>參數</b>  |                             |              |              |                     |      |
|             | id                 | int          |              |     帳號id(流水號)      |   o  |
|             | company_name                         | string          |              |         長度1~50       |   O  |
|             | email                         | string          |              |         email格式       |   O  |
|             | status                 | string          |              |     狀態(on:開啟/off:關閉)       |   O  |
|             | password                         | string          |              |         密碼,長度4~16       |   x  |
|             | password_confirmation                         | string          |              |         密碼確認       |   x  |
|             | role_id                         | int          |              |         角色id(流水號)       |   O  |

> 刪除

| 項目         | 內容                         | 類型         | 預設         | 說明                  | 必填  |
|-------------|-----------------------------|--------------|--------------|---------------------|-------|
| <b>路徑</b>  |admin/systemSetting/userDel|              |              |                     |      |
| <b>方法</b>  | POST                         |              |              |                     |      |
| <b>權限</b>  | system.setting.user.manage         |              |              |          -          |      |
|             | id                 | int          |              |     帳號id(流水號)      |   o  |
