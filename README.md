RBAC权限控制演示
==============
基于角色的访问控制（Role-Based Access Control）作为传统访问控制（自主访问，强制访问）的有前景的代替受到广泛的关注。在RBAC中，权限与角色相关联，用户通过成为适当角色的成员而得到这些角色的权限。这就极大地简化了权限的管理。在一个组织中，角色是为了完成各种工作而创造，用户则依据它的责任和资格来被指派相应的角色，用户可以很容易地从一个角色被指派到另一个角色。角色可依新的需求和系统的合并而赋予新的权限，而权限也可根据需要而从某角色中回收。角色与角色的关系可以建立起来以囊括更广泛的客观情况。具体大家可以参考博文[RBAC】打造Web权限控制系统]](http://www.vincentguo.cn/default/42.html)

技术选型
============
* Yii2
* Mysql
* Bootstrap
* jQuery

快速运行项目步骤
================
* git clone 

文档
==========
* [数据库文件](./docs/mysql.MD)
* [Nginx配置](./docs/nginx.md)
* [Apache配置](./docs/apache.md)
* [【RBAC】打造Web权限控制系统](http://www.vincentguo.cn/default/42.html)