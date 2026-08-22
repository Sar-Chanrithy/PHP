select count(*) as "total_user" from users where age > 2;

select sum(points) from users;

select  AVG(points) as "Average",sum(age) as "Sum",count(*) as "Count" from users;

select name,age from users where age =(
    select max(age)  from users
);

select name,age from users where age = (select min(age) from users);

select group_concat(age order by age desc) from users;

select count(distinct age) from users order by age;

select avg(age) ,stddev(age) from users;

select count(age),avg(age) from users having avg(age)>2;