Nginx配置
=======================

    server {
        charset utf-8;
        client_max_body_size 128M;
        listen 80;
        server_name rbac.yii.local.com;
   
        root  /home/www/yii/rbac/web;
        index  index.php;
    
        location ~* \.(eot|otf|ttf|woff)$ {
           	add_header Access-Control-Allow-Origin *;
        }
    
        location / {
            try_files $uri $uri/ /index.php?$args;
        }
    
        location ~ \.php$ {
            include   fastcgi_params;
            fastcgi_index    index.php;
            fastcgi_param    SCRIPT_FILENAME    $document_root$fastcgi_script_name;
            fastcgi_pass   127.0.0.1:9000;
            try_files $uri =404;
        }
   
    }
