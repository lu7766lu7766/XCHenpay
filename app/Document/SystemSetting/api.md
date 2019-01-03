# 系統設置

### 後台API   

##### 帳號管理 ##### 
---
`角色列表(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/getRolesList       |              |              |             |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | systemSetting.getRolesList     |              |             | -         |
| <b>參數</b>               |            |              |              |        |

`帳號列表查詢(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userList       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userList     |              |             | -         |
| <b>參數</b>               |     status (非必填)       |     string         |              |    狀態(on:開啟/off:關閉)    |
|              |     keyword (非必填)       |     string         |              |    關鍵字(模糊比對帳戶名稱與信箱)    |
|                |     page (非必填)       |     integer         |       1       |    頁數    |
|              |     perpage (非必填)       |     integer         |     10         |    每頁筆數    |

`帳號列表總筆數(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userTotal       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userTotal     |              |             | -         |
| <b>參數</b>               |     status       |     string         |              |    狀態(on:開啟/off:關閉)    |
|               |     keyword (非必填)   |     string         |              |    關鍵字(模糊比對帳戶名稱與信箱)    |

`帳號資料明細(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userDetail       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userDetail     |              |             | -         |
| <b>參數</b>               |     id (必填)       |     integer         |              |    帳號id    |

`帳號新增(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userAdd       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userAdd     |              |             | -         |
| <b>參數</b>               |     company_name (必填)      |     string         |              |    名稱    |
|               |     email (必填)       |     string         |              |    信箱    |
|               |     status (必填)      |     string         |              |    狀態(on:開啟/off:關閉)    |
|               |     password (必填)      |     string         |              |    密碼(長度4~16)    |
|               |     password_confirmation (必填)      |     string         |              |    密碼(長度4~16)    |
|               |     role_id (必填)      |     integer         |              |    角色id    |

`帳號更新(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userUpdate       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userAdd     |              |             | -         |
| <b>參數</b>               |     company_name (必填)      |     string         |              |    名稱    |
|               |     email (必填)       |     string         |              |    信箱    |
|               |     status (必填)      |     string         |              |    狀態(on:開啟/off:關閉)    |
|               |     password (非必填)      |     string         |              |    密碼(長度4~16)    |
|               |     password_confirmation (非必填)      |     string         |              |    密碼(長度4~16)    |
|               |     role_id (必填)      |     integer         |              |    角色id    |

`帳號刪除(非商戶)`

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |{domain}/admin/systemSetting/userDel       |              |              |             |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | systemSetting.userAdd     |              |             | -         |
| <b>參數</b>               |     id (必填)      |     integer         |              |    帳號id    |
