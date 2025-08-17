-- PeriodicTracker Database Schema
-- Generated from application code analysis

CREATE DATABASE IF NOT EXISTS periodictracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE periodictracker;

-- Users table for authentication and profiles
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(255),
    email VARCHAR(255),
    bio TEXT,
    profile_image_url VARCHAR(255),
    public_listed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Element collection status tracking
CREATE TABLE statuses (
    user_id INT NOT NULL,
    symbol VARCHAR(5) NOT NULL,
    status VARCHAR(50) DEFAULT '',
    description TEXT,
    image_url VARCHAR(255),
    quantity DECIMAL(10,3) DEFAULT 0,
    purity DECIMAL(5,2) DEFAULT 100.00,
    is_wish BOOLEAN DEFAULT FALSE,
    wishlist_priority INT DEFAULT 0,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, symbol),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_symbol (symbol),
    INDEX idx_status (status),
    INDEX idx_last_modified (last_modified)
);

-- Achievement/badge system
CREATE TABLE achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    badge_name VARCHAR(255) NOT NULL,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_badge (user_id, badge_name),
    INDEX idx_badge_name (badge_name)
);

-- Comments on user elements
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_user_id INT NOT NULL,
    symbol VARCHAR(5) NOT NULL,
    commenter_username VARCHAR(255) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_owner_symbol (owner_user_id, symbol),
    INDEX idx_created_at (created_at)
);

-- Sample specimens (multiple per element)
CREATE TABLE samples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    symbol VARCHAR(5) NOT NULL,
    status VARCHAR(50) DEFAULT '',
    description TEXT,
    image_url VARCHAR(255),
    quantity DECIMAL(10,3) DEFAULT 0,
    purity DECIMAL(5,2) DEFAULT 100.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_symbol (user_id, symbol),
    INDEX idx_created_at (created_at)
);

-- Create uploads directory placeholder
-- Note: Actual uploads directory should be created on server with proper permissions