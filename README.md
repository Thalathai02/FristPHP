# FristPHP

DB ----->

CREATE TABLE `user` (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  Img TEXT NOT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=utf8;