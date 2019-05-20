# 監聽設置-銀行簡訊範本

> 列表

```
{
        "code": 200,
           "data": [
               {
                   "id": 1,
                   "contents": "1111",
                   "status": "Y",
                   "created_at": "2019-05-14 15:50:52",
                   "updated_at": "2019-05-14 15:50:52",
                   "bank": [
                       {
                           "id": 1,
                           "code": "ICBC",
                           "name": "中国工商银行",
                           "swift_code": null,
                           "created_at": null,
                           "updated_at": null,
                           "pivot": {
                               "template_id": 1,
                               "bank_id": 1
                           }
                       }
                   ]
               }
           ]
}
```


> 列表筆數

```
{
     "code": 200,
     "data": "1"
}
```

> 新增/更新

```
{
       "code": 200,
           "data": {
               "id": 19,
               "contents": "666666",
               "status": "Y",
               "created_at": "2019-05-14 19:32:30",
               "updated_at": "2019-05-14 19:56:25",
               "bank": {
                   "id": 2,
                   "code": "2",
                   "name": "2",
                   "swift_code": "2",
                   "created_at": null,
                   "updated_at": null
               }
           }
}
```

> 單筆資訊

```
{
         "code": 200,
             "data": {
                 "id": 1,
                 "contents": "1111",
                 "status": "Y",
                 "created_at": "2019-05-14 15:50:52",
                 "updated_at": "2019-05-14 15:50:52",
                 "bank": [
                     {
                         "id": 1,
                         "code": "ICBC",
                         "name": "中国工商银行",
                         "swift_code": null,
                         "created_at": null,
                         "updated_at": null,
                         "pivot": {
                             "template_id": 1,
                             "bank_id": 1
                         }
                     }
                 ]
             }
}
```

> 前台-取得簡訊範本

```
{
          "code": 200,
            "data": [
                {
                    "id": 16,
                    "code": "ICBC",
                    "name": "中国工商银行",
                    "swift_code": null,
                    "created_at": "2019-05-15 05:17:28",
                    "updated_at": "2019-05-15 05:17:28",
                    "template": [
                        {
                            "id": 1,
                            "contents": "666666",
                            "status": "Y",
                            "created_at": "2019-05-15 13:35:02",
                            "updated_at": "2019-05-15 13:35:02",
                            "pivot": {
                                "bank_id": 16,
                                "template_id": 1
                            }
                        }
                    ]
                }
            ]
}
```

> 搜尋選項

```
{
          "code": 200,
             "data": [
                 {
                     "id": 1,
                     "code": "ICBC",
                     "name": "中国工商银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:28"
                 },
                 {
                     "id": 2,
                     "code": "ABC",
                     "name": "中国农业银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 3,
                     "code": "BOC",
                     "name": "中国银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 4,
                     "code": "CCB",
                     "name": "中国建设银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 5,
                     "code": "BOCOM",
                     "name": "交通银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 6,
                     "code": "CNCB",
                     "name": "中信银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 7,
                     "code": "CMBC",
                     "name": "中国民生银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 8,
                     "code": "GDB",
                     "name": "广发银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 9,
                     "code": "CMB",
                     "name": "招商银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 10,
                     "code": "CIB",
                     "name": "兴业银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 11,
                     "code": "SPDBD",
                     "name": "上海浦东发展银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 12,
                     "code": "PSBC",
                     "name": "中国邮政储蓄银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 13,
                     "code": "PAB",
                     "name": "平安银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 14,
                     "code": "CEB",
                     "name": "中国光大银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 },
                 {
                     "id": 15,
                     "code": "HXB",
                     "name": "华夏银行",
                     "swift_code": null,
                     "created_at": "2019-05-15 06:32:13",
                     "updated_at": "2019-05-15 06:32:13"
                 }
             ]
}
```
