INSERT INTO orders(user_id,amount) 
VALUES (1,30),
		(3,60),
        (3,50),
        (4,70),
        (5,90),
        (6,40),
        (7,100)

;



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
