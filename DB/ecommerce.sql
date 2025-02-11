-- Drop the database if it exists and then re-create it
DROP DATABASE IF EXISTS ecommerce_PHP;
CREATE DATABASE ecommerce_PHP CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecommerce_PHP;

-----------------------------------------------------
-- Categories Table
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    __typename VARCHAR(50) NOT NULL DEFAULT 'Category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-----------------------------------------------------
-- Products Table
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    inStock BOOLEAN NOT NULL,
    description TEXT,
    category INT,  -- This should reference categories.id (numeric)
    brand VARCHAR(100),
    __typename VARCHAR(50) NOT NULL DEFAULT 'Product',
    CONSTRAINT fk_products_category FOREIGN KEY (category)
        REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Gallery Table (One-to-Many: Products → Gallery)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    CONSTRAINT fk_gallery_product FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    INDEX idx_gallery_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Attributes Table (One-to-Many: Products → Attributes)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS attributes (
    id VARCHAR(50) PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    __typename VARCHAR(50) NOT NULL DEFAULT 'AttributeSet',
    CONSTRAINT fk_attributes_product FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    INDEX idx_attributes_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Attribute Items Table (One-to-Many: Attributes → Items)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS items (
    id VARCHAR(50) PRIMARY KEY,
    attribute_id VARCHAR(50) NOT NULL,
    displayValue VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    __typename VARCHAR(50) NOT NULL DEFAULT 'Attribute',
    CONSTRAINT fk_items_attribute FOREIGN KEY (attribute_id)
        REFERENCES attributes(id)
        ON DELETE CASCADE,
    INDEX idx_items_attribute (attribute_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Currency Table (Unique currency details)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS currency (
    label VARCHAR(10) PRIMARY KEY,  -- e.g., "USD", "EUR"
    symbol VARCHAR(10) NOT NULL,
    __typename VARCHAR(50) NOT NULL DEFAULT 'Currency'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Prices Table (One-to-Many: Products → Prices)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(10) NOT NULL, 
    __typename VARCHAR(50) NOT NULL DEFAULT 'Price',
    CONSTRAINT fk_prices_product FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_prices_currency FOREIGN KEY (currency)
        REFERENCES currency(label)
        ON DELETE CASCADE,
    INDEX idx_prices_product (product_id),
    INDEX idx_prices_currency (currency)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Users Table
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Orders Table
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
    INDEX idx_orders_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-----------------------------------------------------
-- Order Items Table (One-to-Many: Orders → Order Items)
-----------------------------------------------------
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    INDEX idx_order_items_order (order_id),
    INDEX idx_order_items_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-----------------------------------------------------
-- Sample Data Insertion
-----------------------------------------------------
-- Insert a category (e.g., "clothes")
INSERT INTO categories (name, __typename)
VALUES ('clothes', 'Category');

-- Insert a product (ensure the category column is a numeric ID; here assuming "clothes" has id=1)
INSERT INTO products (id, name, inStock, description, category, brand, __typename)
VALUES ('jacket-canada-goosee', 'Jacket', TRUE, '<p>Awesome winter jacket</p>', 1, 'Canada Goose', 'Product');

-- Insert gallery images for the product
INSERT INTO gallery (product_id, image_url)
VALUES
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),
    ('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png');

-- Insert an attribute "Size" for the product
INSERT INTO attributes (id, product_id, name, type, __typename)
VALUES ('Size', 'jacket-canada-goosee', 'Size', 'text', 'AttributeSet');

-- Insert attribute items for "Size"
INSERT INTO items (id, attribute_id, displayValue, value, __typename)
VALUES
    ('Small', 'Size', 'Small', 'S', 'Attribute'),
    ('Medium', 'Size', 'Medium', 'M', 'Attribute'),
    ('Large', 'Size', 'Large', 'L', 'Attribute'),
    ('ExtraLarge', 'Size', 'Extra Large', 'XL', 'Attribute');

-- Insert currency data
INSERT INTO currency (label, symbol, __typename)
VALUES ('USD', '$', 'Currency');

-- Insert price for the product
INSERT INTO prices (product_id, amount, currency, __typename)
VALUES ('jacket-canada-goosee', 518.47, 'USD', 'Price');

-- Insert an attribute "Color" for the product
INSERT INTO attributes (id, product_id, name, type, __typename)
VALUES ('Color', 'jacket-canada-goosee', 'Color', 'text', 'AttributeSet');

-- Insert attribute items for "Color"
INSERT INTO items (id, attribute_id, displayValue, value, __typename)
VALUES
    ('White', 'Color', 'White', '#FFFFFF', 'Attribute'),
    ('Blue', 'Color', 'Blue', '#030BFF', 'Attribute'),
    ('Green', 'Color', 'Green', '#44FF03', 'Attribute');

-- Insert a user
INSERT INTO users (username, email)
VALUES ('reham_eid', 'reham@example.com');

-- Insert an order for the user (assuming user id = 1)
INSERT INTO orders (user_id, total_price)
VALUES (1, 99.99);

-- Insert an order item for the order (using product id 'jacket-canada-goosee')
INSERT INTO order_items (order_id, product_id, quantity)
VALUES (1, 'jacket-canada-goosee', 1);

-----------------------------------------------------
-- Sample Query
-----------------------------------------------------
SELECT o.id, o.total_price, o.created_at
FROM orders o
JOIN users u ON o.user_id = u.id
WHERE u.id = 1;


