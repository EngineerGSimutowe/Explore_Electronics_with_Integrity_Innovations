CREATE DATABASE IF NOT EXISTS explore_integrity_electronics;
USE explore_integrity_electronics;

-- Table for emerging trends
CREATE TABLE IF NOT EXISTS emerging_trends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

-- Table for video tutorials
CREATE TABLE IF NOT EXISTS video_tutorials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    embed_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

-- Insert default data for emerging trends
INSERT INTO emerging_trends (content_url, title, description) VALUES
('https://www.techtarget.com/searchcio/tip/Top-edge-computing-trends-to-watch-in-2020', 'AI & Edge Computing', 'Integration of AI models into embedded devices for real-time analytics and control.'),
('https://energyevolutionconference.com/smart-grid-technology-trends-to-watch/', 'Smart Grid Technologies', 'Resilient, self-healing grid systems with real-time monitoring and decentralized energy control.'),
('https://www.greenlancer.com/post/ev-market-trends', 'Electric Vehicles (EV) Ecosystem', 'Fast-charging tech, powertrain optimization, and V2G integration for sustainable mobility.'),
('https://www.infohost.com.sg/ieee-cs-trends-in-quantum-computing/', 'Quantum Computing in EEE', 'Early-stage applications in fault simulation, optimization, and secure communication systems.'),
('https://axial.acs.org/materials-science/wearable-technology-trends-innovations-and-future-directions', 'Flexible & Wearable Electronics', 'Advances in soft circuitry, bio-integrated sensors, and next-gen materials for EEE health tech.');

-- Insert default data for video tutorials
INSERT INTO video_tutorials (embed_url, title, description) VALUES
('https://www.youtube.com/embed/oi-wpuRfmgI', 'Ohm\'s Law', 'Understand the fundamental relationship between voltage, current, and resistance.'),
('https://www.youtube.com/embed/-72sdXE_H2Q', 'Kirchhoff\'s Laws', 'Learn how Kirchhoff’s current and voltage laws govern circuit analysis.'),
('https://www.youtube.com/embed/n9FxHA7pI6o', 'Diodes & Rectifiers', 'Explore diode operation and how rectifiers convert AC to DC.');
USE explore_integrity_electronics;

-- Products table for buy.php
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Research categories table
CREATE TABLE IF NOT EXISTS research_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

-- Research papers table
CREATE TABLE IF NOT EXISTS research_papers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publication_info VARCHAR(255) NOT NULL,
    abstract TEXT,
    link VARCHAR(255)
);

-- Demo projects table
CREATE TABLE IF NOT EXISTS demo_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    youtube_url VARCHAR(255) NOT NULL,
    details TEXT
);

-- Cart table
CREATE TABLE IF NOT EXISTS user_carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    cart_data TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default products
INSERT INTO products (name, price, image_path) VALUES
('Arduino UNO', 120.00, 'images/ArduinoUNO.png'),
('Buck Converter', 40.00, 'images/BuckConverter.png'),
('Ultrasonic Sensor', 50.00, 'images/UltrasonicSensor.png'),
('4 Channel Relay', 60.00, 'images/4ChannelRelay.png'),
('ESP8266', 90.00, 'images/ESP8266.png'),
('MQ3 Sensor', 35.00, 'images/MQ3Sensor.png'),
('PIR Sensor', 45.00, 'images/PIRSensor.png'),
('9V Power Supply', 25.00, 'images/9VPowerSupply.png');

-- Insert default research categories
INSERT INTO research_categories (title, description) VALUES
('Power Systems', 'Exploring advanced transmission and distribution networks, smart grid tech, and fault diagnosis systems.'),
('Embedded Systems', 'Microcontroller-based designs, IoT, and real-time systems development for automation and control.'),
('Renewable Energy', 'Research in solar, wind, and hybrid energy systems, energy storage, and sustainable grid integration.'),
('Control & Automation', 'Modeling and simulation of control systems, robotics, and automation solutions in EEE.'),
('AI in EEE', 'Machine learning and AI applications in fault detection, smart diagnostics, and predictive maintenance.');

-- Insert default research papers
INSERT INTO research_papers (title, publication_info) VALUES
('AI-Driven Fault Detection in Power Systems', 'Published in IEEE Transactions on Smart Grid (2023)'),
('Energy Optimization in Microgrid Systems', 'Published in Elsevier Renewable Energy (2022)');

-- Insert default demo projects
INSERT INTO demo_projects (title, description, youtube_url, details) VALUES
('ESP32 Weather Station', 'Build a real-time weather dashboard with temperature, humidity, and WiFi display.', 'https://www.youtube.com/embed/R0vOP0x9tiU', 'This project uses an ESP32 microcontroller with a DHT11 temperature/humidity sensor and an OLED screen to show real-time weather conditions. Connects to Wi-Fi to also show network status.'),
('Arduino Home Automation', 'Control lights and appliances using your smartphone and Arduino over Bluetooth.', 'https://www.youtube.com/embed/FTAxMiX_mU0', 'A beginner-friendly home automation system using Arduino UNO and a relay module. You can control lights, fans, and other devices using the Blynk app on your phone.'),
('Obstacle Avoidance Robot', 'Use L298N motor driver and ultrasonic sensor to build an autonomous robot car.', 'https://www.youtube.com/embed/RgnT7DXslZM', 'This project features an autonomous robot car that uses an HC-SR04 ultrasonic sensor to detect and avoid obstacles. Ideal for robotics beginners and students.');