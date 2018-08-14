## CEAL Reporter

This application is a simple application that interfaces with the DPT tool with read-only access that allows the user to run simple analytics on the DPT tool.

| Info  | Value |
| ------------- | ------------- |
| PORT          | 8080          |
| Waffle  | [Board](https://waffle.io/uniti-tim/ceal_reporter)  |

This application uses a cron task to mail a report at the end of every month. Currently the cron task runs at 4:30PM daily - and the scheduler check if today is the last day of month.
