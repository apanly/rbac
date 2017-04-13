RBAC权限控制演示
==============
基于角色的访问控制（Role-Based Access Control）作为传统访问控制（自主访问，强制访问）的有前景的代替受到广泛的关注。在RBAC中，权限与角色相关联，用户通过成为适当角色的成员而得到这些角色的权限。这就极大地简化了权限的管理。在一个组织中，角色是为了完成各种工作而创造，用户则依据它的责任和资格来被指派相应的角色，用户可以很容易地从一个角色被指派到另一个角色。角色可依新的需求和系统的合并而赋予新的权限，而权限也可根据需要而从某角色中回收。角色与角色的关系可以建立起来以囊括更广泛的客观情况。具体大家可以参考博文[【RBAC】打造Web权限控制系统](http://www.54php.cn/default/42.html)

技术选型
============
* Yii2
* Mysql
* Bootstrap
* jQuery

为热心同学点赞
===============
* [Python RBAC 看了视频同学自己实现的](https://github.com/gaoyaxing24/RBAC)

快速运行项目步骤（有疑问可以加入QQ交流群：325264502）
================
* 下载地址
    * Bootstrap：http://d.bootcss.com/bootstrap-3.3.0-dist.zip
    * Yii2：http://github.com/yiisoft/yii2/releases/download/2.0.10/yii-basic-app-2.0.10.tgz
    * jQuery：http://cdn.static.yunetidc.com/jquery/jquery.min.js
* git clone git@github.com:apanly/rbac.git  或者  git clone git@git.oschina.net:apanly/rbac.git (不能访问github的使用oschina)
* 配置web server 请参考文档部分的 nginx 或者 apache
* 数据库配置
    * 新建数据库名 rbac
    * 参考文档部分 数据库文件 将 里面的 sql 语句 全部执行
    * [可选] 修改 config/db.php 文件 配置 username 和 password 为自己环境数据库用户名和密码
* 配置一个本地域名
    * 域名：rbac.yii.local.com
    * 本机ip：127.0.0.1（特殊情况自己查ip）
    * 绑定hosts   域名  ip
* 浏览器 访问 http://rbac.yii.local.com/
* 鼓掌

文档
==========
* [数据库文件](./docs/mysql.MD)
* [Nginx配置](./docs/nginx.md)
* [Apache配置](./docs/apache.md)
* [【RBAC】打造Web权限控制系统](http://www.54php.cn/default/42.html)
* [Yii2中文社区](http://www.yiichina.com/doc/guide/2.0/intro-yii)

支持一下呗
====================
* ![微信公众号](./docs/images/imguowei_888.jpg)
