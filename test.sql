Create DATABASE cms;
create table category (
id INT(10) PRIMARY KEY AUTO_INCREMENT,
title VARCHAR(50),
author VARCHAR(50),
datetime VARCHAR(50)
);
select * from category;
use cms;
show tables;

create table posts(
id INT(10) PRIMARY KEY AUTO_INCREMENT,
datetime VARCHAR(50),
title VARCHAR(300),
category VARCHAR(50),
author VARCHAR(50),
image VARCHAR(50),
post VARCHAR(1000)
);
show tables;
select * from posts;

create table comments(
   id int(10) PRIMARY KEY AUTO_INCREMENT,
   datetime varchar(50),
   name varchar(50),
   email varchar(60),
   comment varchar(500)
);

ALTER TABLE comments
  ADD COLUMN approvedby varchar(50) AFTER comment;
  ADD COLUMN status varchar(3);

create table admins(
   id INT(10) PRIMARY KEY AUTO_INCREMENT,
   datetime VARCHAR(50) ,
   username VARCHAR(50),
   password VARCHAR(60),
   aname VARCHAR(30),
   addedby VARCHAR(30)
);

show tables;
select * from admins;
DROP TABLE admins;




