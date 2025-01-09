-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45) NOT NULL,
    s_name VARCHAR(45) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cars table
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    availability ENUM('available', 'unavailable') DEFAULT 'available',
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    pickup_location VARCHAR(255) NOT NULL,
    return_location VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Reviews table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Linking cars to categories
ALTER TABLE cars
ADD COLUMN category_id INT,
ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;

-- cretae articles table for blog 
USE
    `d&l`;
CREATE TABLE IF NOT EXISTS `articles`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(50) NOT NULL,
    `content` TEXT NOT NULL,
    `image` VARCHAR(100) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_favorite` BOOLEAN DEFAULT FALSE,
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- create comments table for blog 
CREATE TABLE IF NOT EXISTS `comments`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `article_id` INT(11) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `comment` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- create favorite table for blog 
CREATE TABLE IF NOT EXISTS `favorite`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `article_id` INT(11) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- create category_blog table for blog 
CREATE TABLE IF NOT EXISTS `category_blog`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- create tags table for blog 
CREATE TABLE IF NOT EXISTS `tags`(
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- create article_tags junction table
CREATE TABLE IF NOT EXISTS `article_tags` (
    `article_id` INT(11) NOT NULL,
    `tag_id` INT(11) NOT NULL,
    'is_accpted' enum('pending', 'accepted', 'rejected') default 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`article_id`, `tag_id`),
    FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
);

alter table articles add column category_id int;
alter table articles add foreign key (category_id) references category_blog(id) on delete set null;
alter table articles add column tag_id int;
alter table articles add foreign key (tag_id) references tags(id) on delete set null;

-- Insert sample tags if they don't exist
INSERT INTO tags (name) VALUES 
('Technology'),
('Web Development'),
('Design'),
('Programming'),
('UI/UX'),
('Database'),
('Security'),
('Mobile'),
('Cloud'),
('DevOps');

-- Insert sample data into article_tags junction table
INSERT INTO article_tags (article_id, tag_id) VALUES 
(1, 1),  -- Article 1 with Technology
(1, 2),  -- Article 1 with Web Development
(1, 3),  -- Article 1 with Design
(2, 2),  -- Article 2 with Web Development
(2, 4),  -- Article 2 with Programming
(3, 1),  -- Article 3 with Technology
(3, 3),  -- Article 3 with Design
(4, 2),  -- Article 4 with Web Development
(4, 4),  -- Article 4 with Programming
(5, 1),  -- Article 5 with Technology
(5, 3),  -- Article 5 with Design
(6, 2),  -- Article 6 with Web Development
(6, 4),  -- Article 6 with Programming
(1, 5),  -- Article 1 with UI/UX
(2, 6),  -- Article 2 with Database
(3, 7),  -- Article 3 with Security
(4, 8),  -- Article 4 with Mobile
(5, 9),  -- Article 5 with Cloud
(6, 10); -- Article 6 with DevOps