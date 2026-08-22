CREATE TABLE categories(
    category_id int primary key AUTO_INCREMENT,
    category_name VARCHAR(100) not null
);

INSERT INTO categories (category_name)
VALUES  ('Drink'),
		('chicken'),
        ('burger'),
		('Pizza'),
		('Pasta'),
		('Seafood'),
		('Dessert'),
		('Coffee & Tea'),
		('Bakery'),
		('Appetizer'),
		('Soup & Salad'),
		('Noodles'),
		('Rice Dishes'),
		('Snacks'),
		('Vegetarian');
		

select * from categories;

CREATE TABLE product (
    product_id int AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50) NOT NULL,
    price decimal(10,2) not null,
    category_id int ,
    brand_id int,
    constraint fk_products_brand
    FOREIGN KEY (brand_id)
    REFERENCES categories(category_id)
    on delete set null
    ON UPDATE CASCADE,
    constraint fk_products_categories
    FOREIGN KEY (category_id)
    REFERENCES categories(category_id)
    on delete set null
    ON UPDATE CASCADE
);

CREATE TABLE brand(
    brand_id int primary key AUTO_INCREMENT,
    brand_name VARCHAR(100) not null
);

select * from brand;

INSERT INTO brand (brand_name)
VALUES 
    ('Coca-Cola'),
    ('Pepsi'),
    ('Omakase'),
    ('KFC'),
    ('Burger King');

INSERT INTO product (product_name, price, category_id, brand_id)
VALUES 
    ('Coca', 33.00, 1, 1),
    ('Orange Juice', 2.50, 2, 2),   
    ('Grilled Salmon', 12.00, 3, 3), 
    ('Fried Chicken', 5.50, 4, 4),  
    ('Cheese Burger', 4.00, 5, 5);

SELECT * FROM product;

SELECT 
    c.category_id,
    c.category_name,
    p.product_name,
    p.price,
    b.brand_name
FROM product p
LEFT JOIN categories c ON p.category_id = c.category_id
LEFT JOIN brand b ON p.brand_id = b.brand_id;

