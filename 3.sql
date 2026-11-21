select * from users;
select * from orders;

create table orders (
    order_id int PRIMARY KEY AUTO_INCREMENT,
    user_id int,
    amount decimal(10,2),
    order_date datetime default CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

insert into orders (user_id,amount) value (1,30),
(3,20),
(3,40),
(5,80);


-- --INNER JOIN
select users.id as user_id,
    users.name,
    users.age,
    orders.order_id,
    orders.amount
from users
INNER JOIN orders on users.id = orders.user_id;


-- LEFT JOIN
select users.id as user_id,
users.name,
orders.amount,
orders.order_id
from users
left join orders on users.id = orders.user_id;

select users.id as user_id,
users.name,
orders.amount,
orders.order_id
from users
left join orders on users.id = orders.user_id where orders.amount is null;