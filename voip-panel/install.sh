#!/bin/bash

##############################################################################
# FreeSWITCH VoIP Panel Installation Script
# For Debian 11/12 with SignalWire FreeSWITCH
##############################################################################

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Log functions
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    log_error "Please run as root"
    exit 1
fi

# Get SignalWire token
echo "======================================"
echo "FreeSWITCH VoIP Panel Installer"
echo "======================================"
echo ""

read -p "Enter your SignalWire TOKEN: " TOKEN

if [ -z "$TOKEN" ]; then
    log_error "TOKEN is required"
    exit 1
fi

# Update system
log_info "Updating system packages..."
apt-get update && apt-get upgrade -y

# Install prerequisites
log_info "Installing prerequisites..."
apt-get install -y \
    gnupg2 \
    wget \
    lsb-release \
    curl \
    git \
    nginx \
    mariadb-server \
    php8.2 \
    php8.2-fpm \
    php8.2-cli \
    php8.2-mysql \
    php8.2-xml \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-zip \
    php8.2-gd \
    php8.2-bcmath \
    composer \
    redis-server \
    supervisor \
    nodejs \
    npm

# Update npm to latest version
log_info "Updating npm to latest version..."
npm install -g npm@latest

# Install FreeSWITCH from SignalWire
log_info "Installing FreeSWITCH from SignalWire..."

# Add SignalWire GPG key
wget --http-user=signalwire --http-password=$TOKEN \
    -O /usr/share/keyrings/signalwire-freeswitch-repo.gpg \
    https://freeswitch.signalwire.com/repo/deb/debian-release/signalwire-freeswitch-repo.gpg

# Configure APT authentication
echo "machine freeswitch.signalwire.com login signalwire password $TOKEN" > /etc/apt/auth.conf
chmod 600 /etc/apt/auth.conf

# Add FreeSWITCH repository
echo "deb [signed-by=/usr/share/keyrings/signalwire-freeswitch-repo.gpg] https://freeswitch.signalwire.com/repo/deb/debian-release/ `lsb_release -sc` main" > /etc/apt/sources.list.d/freeswitch.list
echo "deb-src [signed-by=/usr/share/keyrings/signalwire-freeswitch-repo.gpg] https://freeswitch.signalwire.com/repo/deb/debian-release/ `lsb_release -sc` main" >> /etc/apt/sources.list.d/freeswitch.list

# Update and install FreeSWITCH
apt-get update

log_info "Installing FreeSWITCH meta packages..."
apt-get install -y freeswitch-meta-all

# Install specific modules
log_info "Installing FreeSWITCH modules..."
apt-get install -y \
    freeswitch-mod-esl \
    freeswitch-mod-sofia \
    freeswitch-mod-callcenter \
    freeswitch-mod-conference \
    freeswitch-mod-verto \
    freeswitch-mod-flite \
    freeswitch-mod-pocketsphinx \
    freeswitch-mod-lcr \
    freeswitch-mod-nibblebill \
    freeswitch-mod-easyroute \
    freeswitch-mod-mariadb \
    freeswitch-mod-db

# Setup MariaDB
log_info "Setting up MariaDB..."
mysql_secure_installation

log_info "Creating database for VoIP Panel..."
mysql -e "CREATE DATABASE IF NOT EXISTS voip_panel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS 'voipuser'@'localhost' IDENTIFIED BY 'VoipP@ss123!';"
mysql -e "GRANT ALL PRIVILEGES ON voip_panel.* TO 'voipuser'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# Configure FreeSWITCH
log_info "Configuring FreeSWITCH..."
systemctl enable freeswitch
systemctl start freeswitch

# Setup VoIP Panel
log_info "Setting up VoIP Panel..."
PANEL_DIR="/var/www/voip-panel"

if [ -d "$PANEL_DIR" ]; then
    log_warn "Panel directory exists, backing up..."
    mv $PANEL_DIR ${PANEL_DIR}_backup_$(date +%Y%m%d_%H%M%S)
fi

# Get the script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Copy panel files
log_info "Copying panel files from $SCRIPT_DIR to $PANEL_DIR..."
cp -r "$SCRIPT_DIR" "$PANEL_DIR"
cd "$PANEL_DIR"

# Install PHP dependencies
log_info "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
log_info "Installing latest Node.js dependencies..."
npm install

# Build frontend assets
log_info "Building frontend assets..."
npm run build

# Setup environment
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key
php artisan key:generate

# Update .env with database credentials
sed -i 's/DB_DATABASE=.*/DB_DATABASE=voip_panel/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=voipuser/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=VoipP@ss123!/' .env

# Run migrations
log_info "Running database migrations..."
php artisan migrate --force

# Install Laravel Breeze
log_info "Installing Laravel Breeze..."
php artisan breeze:install api --no-interaction

# Set permissions
chown -R www-data:www-data "$PANEL_DIR"
chmod -R 755 "$PANEL_DIR"
chmod -R 775 "$PANEL_DIR/storage"
chmod -R 775 "$PANEL_DIR/bootstrap/cache"

# Configure Nginx
log_info "Configuring Nginx..."
cat > /etc/nginx/sites-available/voip-panel <<'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name _;
    root /var/www/voip-panel/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/voip-panel /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and restart Nginx
nginx -t && systemctl restart nginx

# Setup supervisor for queue workers
log_info "Setting up supervisor for Laravel queues..."
cat > /etc/supervisor/conf.d/voip-panel-worker.conf <<EOF
[program:voip-panel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $PANEL_DIR/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=$PANEL_DIR/storage/logs/worker.log
stopwaitsecs=3600
EOF

supervisorctl reread
supervisorctl update
supervisorctl start all

# Final message
echo ""
echo "======================================"
log_info "Installation completed successfully!"
echo "======================================"
echo ""
echo "VoIP Panel URL: http://$(hostname -I | awk '{print $1}')"
echo "Database: voip_panel"
echo "DB User: voipuser"
echo "DB Pass: VoipP@ss123!"
echo ""
echo "FreeSWITCH Status:"
systemctl status freeswitch --no-pager | head -n 5
echo ""
echo "Next steps:"
echo "1. Access the panel at http://your-server-ip"
echo "2. Configure your first admin user"
echo "3. Set up your SIP trunks and extensions"
echo "4. Configure DIDs and routing"
echo ""
log_warn "Remember to secure your installation:"
log_warn "- Change database passwords"
log_warn "- Setup SSL certificate"
log_warn "- Configure firewall rules"
log_warn "- Review FreeSWITCH ACL settings"
echo ""
