Apache VirtualHost
======================
担心大家不使用nginx，这里把apache 虚拟主机的配置也整理出来，像我这么负责的人不多了：）

方法一 
=====================
直接在apache 虚拟主机中配置rewrite规则

    <VirtualHost *:80>
        ServerName rbac.yii.local.com
        DocumentRoot /home/www/yii/rbac/web
        <Directory "/home/www/yii/rbac/web">
            Require all granted
            Allow from all
            RewriteEngine on
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule . index.php
        </Directory>
    </VirtualHost>

方法二
=====================
rewrite规则通过.htaccess文件实现

    <VirtualHost *:8000>
        ServerName rbac.yii.local.com
        DocumentRoot /home/www/yii/rbac/web
    </VirtualHost>
    
    
.htaccess 内容如下（在代码web文件下已有此文件）

    Options +FollowSymLinks
    IndexIgnore */*
    RewriteEngine on
    
    # if a directory or a file exists, use it directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    
    # otherwise forward it to index.php
    RewriteRule . index.php
