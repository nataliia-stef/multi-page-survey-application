CREATE DATABASE survey charset utf8;

CREATE USER 'survey1user'@'localhost' identified by '!Survey123!';

GRANT all privileges ON survey.* to 'survey1user'@'localhost' identified by '!Survey123!';
GRANT all privileges ON survey.* to 'survey1user'@'127.0.0.1' identified by '!Survey123!';

USE survey;

CREATE TABLE if not exists customers (
  cust_id int(11) NOT NULL AUTO_INCREMENT,
  cust_full_name varchar(200) NOT NULL,
  cust_age int(11) NOT NULL,
  cust_stud_type int(11) NOT NULL,
  PRIMARY KEY (cust_id)
);

CREATE TABLE if not exists orders (
  order_id int(11) NOT NULL AUTO_INCREMENT,
  order_cust_id int(11) NOT NULL,
  order_method int(11) NOT NULL,
  PRIMARY KEY (order_id),
  FOREIGN KEY (order_cust_id) REFERENCES customers(cust_id)
);

CREATE TABLE if not exists order_details (
  order_id int(11) NOT NULL,
  order_product varchar(200) NOT NULL,
  order_rating varchar(200) NOT NULL,
  order_recommend varchar(200) NOT NULL,
  PRIMARY KEY (order_id, order_product),
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);