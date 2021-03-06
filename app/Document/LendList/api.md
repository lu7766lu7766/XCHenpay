# 商戶功能 >下發申請

### 後台API

> 金額明細

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/amountInfo       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |

> 下發狀態

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/lendStatus       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |

> index

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/       |              |              |                      |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |
|                |              start_time (必填)                     |  Y-m-d H:i:s            |              |        |
|                |              end_time   (必填)                   |  Y-m-d H:i:s            |              |        |
|                |              status   (非必填)                   | int            |              |        |
|                |              number   (非必填)                   | string            |              |    關鍵字    |
|                |              sort   (必填)                   | string            |              |    DESC|ASC   |

> 申請下發

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/apply       |              |              |                      |
| <b>方法</b>               | POST          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |
|                |              target_id (必填)                     |  integer            |              |    下發帳戶ID    |
|                |              amount (必填)                     |  integer            |              |    下發金額    |
|                |              note (非必填)                     |  string            |              |    備註    |

> 總數

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/total       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |
|                |              start_time (必填)                     |  Y-m-d H:i:s              |              |        |
|                |              end_time (必填)                     |   Y-m-d H:i:s               |              |        |
|                |              status (非必填)                     |  int            |              |        |
|                |              number   (非必填)                        |  string            |              |       關鍵字 |

> info

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/{id}       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |

> 銀行帳戶資訊

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/backAccountInfo       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |

> 商戶資訊

| 項目                        | 內容                              | 類型         | 預設         | 說明        |
|-------------------|------------------------|--------------|--------------|-----------------------------|
| <b>路徑</b>         |domain/admin/lendList/userInfo       |              |              |                      |
| <b>方法</b>               | GET          |              |              |          |
| <b>權限</b>               | lendList     |              |             | -         |
| <b>參數</b>               |                                    |              |              |        |




