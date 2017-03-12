# onedrive_share
利用Onedrive 作存储载体的个人分享网盘



##基础配置

###安装基础

onedrive安装：https://github.com/0oVicero0/OneDrive

PHP>5.3 PHP<7

###文件配置

define('SIZE',1000000);//该项为限制上传文件的大小

/uploads 设置为777 
###php.ini 配置
修改以下配置


max_execution_time=600 //php运行时间建议600s

max_input_time = 600 //最大接受数据时间

memory_limit = 32m //每个进程消耗的内存；

file_uploads = on //是否运行上传 

upload_max_filesize = 200m //最大上传文件大小

post_max_size = 200m //post最大文件大小

开启PHP禁止函数 : disable_functions中的exec()
