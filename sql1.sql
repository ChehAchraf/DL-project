-- Database Setup for Drive & Loc Car Rental

-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45) NOT NULL,
    s_name VARCHAR(45) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Vehicle Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create Vehicles Table
CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    condition  VARCHAR(20) NOT NULL,
    Mileage  int(20) NOT NULL,
    category_id INT,
    availability BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Create Reservations Table
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT,
    user_id INT,
    start_date DATE,
    end_date DATE,
    pickup_location VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create Reviews Table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT,
    user_id INT,
    rating INT CHECK(rating >= 1 AND rating <= 5),
    comment TEXT,
    deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create View for Vehicle List
CREATE VIEW ListeVehicules AS
SELECT v.id AS vehicle_id, v.model, v.price, v.availability, c.name AS category_name, AVG(r.rating) AS avg_rating
FROM vehicles v
LEFT JOIN categories c ON v.category_id = c.id
LEFT JOIN reviews r ON v.id = r.vehicle_id AND r.deleted = FALSE
GROUP BY v.id;

-- Create Stored Procedure for Adding Reservation
DELIMITER $$
CREATE PROCEDURE AjouterReservation(IN p_user_id INT, IN p_vehicle_id INT, IN p_start_date DATE, IN p_end_date DATE, IN p_pickup_location VARCHAR(255))
BEGIN
    DECLARE vehicle_available BOOLEAN;
    
    -- Check if vehicle is available
    SELECT availability INTO vehicle_available FROM vehicles WHERE id = p_vehicle_id;
    
    IF vehicle_available THEN
        INSERT INTO reservations (vehicle_id, user_id, start_date, end_date, pickup_location) 
        VALUES (p_vehicle_id, p_user_id, p_start_date, p_end_date, p_pickup_location);
        
        -- Update vehicle availability
        UPDATE vehicles SET availability = FALSE WHERE id = p_vehicle_id;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Vehicle is not available for the selected dates';
    END IF;
END$$
DELIMITER ;

-- Create Trigger for Soft Delete of Reviews
DELIMITER $$
CREATE TRIGGER soft_delete_review BEFORE DELETE ON reviews
FOR EACH ROW
BEGIN
    UPDATE reviews SET deleted = TRUE WHERE id = OLD.id;
END$$
DELIMITER ;

-- Create Trigger for Email Notification (Assuming email sending is handled outside SQL, e.g., through PHP)
-- For this, you can trigger an event when a reservation status is updated to 'approved' or 'rejected'
DELIMITER $$
CREATE TRIGGER send_email_notification AFTER UPDATE ON reservations
FOR EACH ROW
BEGIN
    IF NEW.status = 'approved' OR NEW.status = 'rejected' THEN
        -- Assuming we call an external function to send email via PHP (not implemented in SQL)
        -- Example: CALL sendEmailNotification(NEW.user_id, NEW.status);
    END IF;
END$$
DELIMITER ;

-- Create Indexes for Performance
CREATE INDEX idx_vehicle_category ON vehicles (category_id);
CREATE INDEX idx_reservation_user ON reservations (user_id);
CREATE INDEX idx_review_vehicle ON reviews (vehicle_id);
