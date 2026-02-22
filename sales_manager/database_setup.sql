

CREATE DATABASE IF NOT EXISTS sales_purchase_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE sales_purchase_db;

CREATE TABLE IF NOT EXISTS sales (
    id             INT            AUTO_INCREMENT PRIMARY KEY,
    customer_name  VARCHAR(150)   NOT NULL,
    product_name   VARCHAR(150)   NOT NULL,
    quantity       DECIMAL(10,2)  NOT NULL DEFAULT 0,
    cost           DECIMAL(10,2)  NOT NULL DEFAULT 0,
    selling_price  DECIMAL(10,2)  NOT NULL DEFAULT 0,
    total_price    DECIMAL(10,2)  NOT NULL DEFAULT 0,
    sale_date      DATE           NOT NULL,
    created_at     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS purchases (
    id              INT            AUTO_INCREMENT PRIMARY KEY,
    vendor_name     VARCHAR(150)   NOT NULL,
    product_name    VARCHAR(150)   NOT NULL,
    per_unit_price  DECIMAL(10,2)  NOT NULL DEFAULT 0,
    purchased_units DECIMAL(10,2)  NOT NULL DEFAULT 0,
    total_price     DECIMAL(10,2)  NOT NULL DEFAULT 0,
    purchase_date   DATE           NOT NULL,
    created_at      TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);
