
SELECT * FROM users;
INSERT INTO users (age,points)
value  (4,55),
       (88,44),
       (2,66),
       (33,88);

select age from users;

select age,points from users where age<34 order by age desc limit 10;

ALTER TABLE users
ADD COLUMN name VARCHAR(100);

UPDATE users set age = 10,name = "kanha" where id =4;

DELETE from users where id = 2;

INSERT INTO users (age,points,name) value (11,33,"pheaktra");
