create table test_sign(
  id int unsigned not null primary key auto_increment comment 'id',
  user_id int unsigned not null comment '用户id',
  date int not null comment '签到时间'
)charset=utf8 engine=innodb;

create table test_user(
  id int unsigned not null primary key auto_increment comment '用户id',
  point int unsigned not null comment '用户积分'
)charset=utf8 engine=innodb;