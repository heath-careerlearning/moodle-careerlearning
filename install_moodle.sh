#!/bin/bash

# Moodle Installation Script for CareerLearning
# This script automates the Moodle installation process

set -e  # Exit on any error

# Configuration
MOODLE_VERSION="401"
MOODLE_URL="https://download.moodle.org/stable${MOODLE_VERSION}/moodle-latest-${MOODLE_VERSION}.tgz"
INSTALL_DIR="/var/www/html"
MOODLE_DIR="${INSTALL_DIR}/moodle"
DB_NAME="moodle"
DB_USER="moodleuser"
DB_PASS=""
WEB_USER="www-data"
WEB_GROUP="www-data"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}"
    exit 1
}

warning() {
    echo -e "${YELLOW}[WARNING] $1${NC}"
}

# Check if running as root
check_root() {
    if [[ $EUID -ne 0 ]]; then
        error "This script must be run as root"
    fi
}

# Check system requirements
check_requirements() {
    log "Checking system requirements..."
    
    # Check PHP
    if ! command -v php &> /dev/null; then
        error "PHP is not installed. Please install PHP 8.0+ first."
    fi
    
    # Check MySQL/MariaDB
    if ! command -v mysql &> /dev/null; then
        error "MySQL/MariaDB is not installed. Please install it first."
    fi
    
    # Check web server
    if ! command -v apache2 &> /dev/null && ! command -v nginx &> /dev/null; then
        error "Neither Apache nor Nginx is installed. Please install one first."
    fi
    
    log "System requirements check passed"
}

# Install PHP extensions
install_php_extensions() {
    log "Installing required PHP extensions..."
    
    local extensions=(
        "php-mysql"
        "php-xml"
        "php-mbstring"
        "php-curl"
        "php-gd"
        "php-intl"
        "php-zip"
        "php-soap"
        "php-opcache"
    )
    
    for ext in "${extensions[@]}"; do
        if ! dpkg -l | grep -q "$ext"; then
            log "Installing $ext..."
            apt-get install -y "$ext" || warning "Failed to install $ext"
        else
            log "$ext is already installed"
        fi
    done
}

# Download and extract Moodle
download_moodle() {
    log "Downloading Moodle ${MOODLE_VERSION}..."
    
    if [ -d "$MOODLE_DIR" ]; then
        warning "Moodle directory already exists. Removing old installation..."
        rm -rf "$MOODLE_DIR"
    fi
    
    cd "$INSTALL_DIR"
    wget -O moodle-latest.tgz "$MOODLE_URL" || error "Failed to download Moodle"
    tar -xzf moodle-latest.tgz || error "Failed to extract Moodle"
    rm moodle-latest.tgz
    
    log "Moodle downloaded and extracted successfully"
}

# Set permissions
set_permissions() {
    log "Setting proper permissions..."
    
    chown -R "$WEB_USER:$WEB_GROUP" "$MOODLE_DIR"
    chmod -R 755 "$MOODLE_DIR"
    
    # Create data directory
    mkdir -p "${MOODLE_DIR}/moodledata"
    chown -R "$WEB_USER:$WEB_GROUP" "${MOODLE_DIR}/moodledata"
    chmod -R 777 "${MOODLE_DIR}/moodledata"
    
    log "Permissions set successfully"
}

# Create database
create_database() {
    log "Creating database..."
    
    if [ -z "$DB_PASS" ]; then
        read -s -p "Enter database password for $DB_USER: " DB_PASS
        echo
    fi
    
    mysql -u root -p -e "
        CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
        GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
        FLUSH PRIVILEGES;
    " || error "Failed to create database"
    
    log "Database created successfully"
}

# Create configuration file
create_config() {
    log "Creating Moodle configuration..."
    
    cat > "${MOODLE_DIR}/config.php" << EOF
<?php
unset(\$CFG);
global \$CFG;
\$CFG = new stdClass();

\$CFG->dbtype    = 'mysqli';
\$CFG->dblibrary = 'native';
\$CFG->dbhost    = 'localhost';
\$CFG->dbname    = '$DB_NAME';
\$CFG->dbuser    = '$DB_USER';
\$CFG->dbpass    = '$DB_PASS';
\$CFG->prefix    = 'mdl_';
\$CFG->dboptions = array(
    'dbpersist' => 0,
    'dbport' => '',
    'dbsocket' => '',
    'dbcollation' => 'utf8mb4_unicode_ci',
);

\$CFG->wwwroot   = 'https://store.careerlearning.com';
\$CFG->dataroot = '${MOODLE_DIR}/moodledata';
\$CFG->admin     = 'admin';

\$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');
EOF

    log "Configuration file created"
}

# Main installation function
main() {
    log "Starting Moodle installation..."
    
    check_root
    check_requirements
    install_php_extensions
    download_moodle
    set_permissions
    create_database
    create_config
    
    log "Moodle installation completed successfully!"
    log "Next steps:"
    log "1. Configure your web server to point to $MOODLE_DIR"
    log "2. Navigate to https://store.careerlearning.com to complete setup"
    log "3. Follow the web-based installation wizard"
    log "4. Configure your site settings and create admin account"
}

# Run main function
main "$@"
