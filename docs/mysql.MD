### 数据库 rbac 中的表
    
    CREATE TABLE `user` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
      `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
      `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
      `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 1表示是 0 表示不是',
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      KEY `idx_email` (`email`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表';
    
    CREATE TABLE `role` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';
    
    CREATE TABLE `user_role` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
      `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      KEY `idx_uid` (`uid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';
    
    CREATE TABLE `access` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
      `urls` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json 数组',
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
      `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次更新时间',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限详情表';
    
    CREATE TABLE `role_access` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
      `access_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
      `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
      PRIMARY KEY (`id`),
      KEY `idx_role_id` (`role_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';
    
    CREATE TABLE `app_access_log` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '品牌UID',
      `target_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的url',
      `query_params` longtext NOT NULL COMMENT 'get和post参数',
      `ua` varchar(255) NOT NULL DEFAULT '' COMMENT '访问ua',
      `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '访问ip',
      `note` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json格式备注字段',
      `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_uid` (`uid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户操作记录表';
    
    
    INSERT INTO `user` (`id`, `name`, `email`, `is_admin`, `status`, `updated_time`, `created_time`)
    VALUES(1, '超级管理员', 'apanly@163.com', 1, 1, '2016-11-15 13:36:30', '2016-11-15 13:36:30');

