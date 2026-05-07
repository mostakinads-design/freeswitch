# Laravel VoIP Panel for FreeSWITCH

A comprehensive, Laravel-based VoIP management panel with AI capabilities for FreeSWITCH. This system provides a complete call center solution with modern web interface, real-time monitoring, and advanced features.

## Features

### Core VoIP Features
- **Extension Management**: Create and manage SIP extensions for users
- **DID Management & Routing**: Configure DIDs with flexible routing options
- **Gateway Configuration**: Set up SIP trunks and carriers
- **IVR Builder**: Easy-to-use IVR system with drag-and-drop interface
- **Ring Groups**: Configure call distribution across multiple extensions
- **Call Queues**: Full-featured call center queuing system

### Call Center Features
- **Agent Dashboard**: Real-time agent interface with softphone integration
- **Multiple Dialer Types**: 
  - Preview Dialer
  - Progressive Dialer
  - Predictive Dialer
  - Power Dialer
- **AI Integration**: Human, AI, and Hybrid call handling modes
- **Answering Machine Detection (AMD)**
- **Real-time CDR Viewer**: Live call detail records
- **Call Recording**: Automatic call recording with playback
- **Queue Management**: Advanced queue strategies and tier rules

### Communication Features
- **Video Conferencing**: Full video conference support via mod_verto
- **SMS Campaigns**: Professional SMS broadcasting with CSV upload
- **Voice Campaigns**: Automated voice broadcasting
- **Campaign Management**: Track campaign progress and results

### Advanced Features
- **AI Capabilities**: 
  - Human mode: Traditional agent-handled calls
  - AI mode: Fully automated AI-driven conversations
  - Hybrid mode: AI assistance with human oversight
- **LCR (Least Cost Routing)**: Intelligent carrier selection
- **Billing System**: Per-minute billing with area code-based rates
- **Multi-tenant Support**: Role-based access (Admin/Agent/User)
- **Real-time Monitoring**: Live call monitoring and statistics

## System Requirements

- Debian 11 or 12
- PHP 8.2 or higher
- MariaDB/MySQL 10.5 or higher
- Nginx or Apache
- Redis (for queues and caching)
- FreeSWITCH (installed via SignalWire)
- Node.js 18+ (for frontend build)

## Installation

### 1. Install FreeSWITCH with SignalWire

```bash
# Set your SignalWire token
TOKEN=your_signalwire_token_here

# Run the installation script
sudo chmod +x install.sh
sudo ./install.sh
```

The installation script will:
- Install FreeSWITCH from SignalWire repository
- Install required FreeSWITCH modules
- Set up MariaDB database
- Configure Nginx web server
- Install and configure the Laravel VoIP Panel
- Set up supervisor for queue workers

### 2. Manual Installation (Alternative)

If you prefer manual installation:

```bash
# Install system dependencies
sudo apt-get update
sudo apt-get install -y nginx mariadb-server php8.2 php8.2-fpm \
    php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl \
    php8.2-zip composer redis-server supervisor

# Install FreeSWITCH
TOKEN=your_token_here
sudo apt-get install -y gnupg2 wget lsb-release

wget --http-user=signalwire --http-password=$TOKEN \
    -O /usr/share/keyrings/signalwire-freeswitch-repo.gpg \
    https://freeswitch.signalwire.com/repo/deb/debian-release/signalwire-freeswitch-repo.gpg

echo "machine freeswitch.signalwire.com login signalwire password $TOKEN" > /etc/apt/auth.conf
chmod 600 /etc/apt/auth.conf

echo "deb [signed-by=/usr/share/keyrings/signalwire-freeswitch-repo.gpg] https://freeswitch.signalwire.com/repo/deb/debian-release/ `lsb_release -sc` main" > /etc/apt/sources.list.d/freeswitch.list

sudo apt-get update
sudo apt-get install -y freeswitch-meta-all

# Install FreeSWITCH modules
sudo apt-get install -y \
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

# Clone and setup the panel
cd /var/www
git clone https://github.com/your-repo/voip-panel.git
cd voip-panel

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Configure environment
cp .env.example .env
php artisan key:generate

# Update database credentials in .env
nano .env

# Run migrations
php artisan migrate

# Build frontend assets
npm install
npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/voip-panel
sudo chmod -R 755 /var/www/voip-panel
sudo chmod -R 775 /var/www/voip-panel/storage
```

## Configuration

### Environment Variables

Edit `.env` file with your configuration:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voip_panel
DB_USERNAME=voipuser
DB_PASSWORD=your_password

# FreeSWITCH
FREESWITCH_HOST=127.0.0.1
FREESWITCH_PORT=8021
FREESWITCH_PASSWORD=ClueCon
FREESWITCH_ESL_HOST=127.0.0.1
FREESWITCH_ESL_PORT=8021

# AI Configuration
OPENAI_API_KEY=your_openai_key
AI_ENABLED=true
AI_MODE=hybrid

# Billing
BILLING_ENABLED=true
DEFAULT_RATE_PER_MINUTE=0.01

# Video Conference
VIDEO_ENABLED=true
VERTO_WS_URL=wss://your-domain.com:8082

# SMS Configuration
SMS_ENABLED=true
SMS_PROVIDER=signalwire
SIGNALWIRE_PROJECT_ID=your_project_id
SIGNALWIRE_TOKEN=your_token
SIGNALWIRE_SPACE=your_space
```

### FreeSWITCH Configuration

The panel automatically generates FreeSWITCH configuration files. Configuration templates are located in:
- `freeswitch-config/dialplan/` - Dialplan templates
- `freeswitch-config/directory/` - User/extension templates
- `freeswitch-config/sip_profiles/` - Gateway templates
- `freeswitch-config/autoload_configs/` - Module configurations

## Usage

### Access the Panel

Navigate to `http://your-server-ip` in your web browser.

Default credentials (create your first admin user):
```bash
php artisan make:admin
```

### Creating Extensions

1. Navigate to **Extensions** in the menu
2. Click **Add Extension**
3. Fill in the extension details:
   - Extension number (e.g., 1001)
   - Password
   - Name
   - Caller ID settings
4. Click **Save**
5. Extension is automatically synced to FreeSWITCH

### Managing DIDs

1. Navigate to **DIDs**
2. Click **Add DID**
3. Configure:
   - DID number
   - Destination type (Extension, IVR, Queue, etc.)
   - Gateway
4. Save to activate

### Creating IVR Menus

1. Navigate to **IVR Builder**
2. Create a new IVR
3. Configure:
   - Greeting (upload audio or use TTS)
   - Menu options and destinations
   - Timeout behaviors
4. Save and test

### Setting Up Campaigns

1. Navigate to **Campaigns**
2. Create **Voice** or **SMS** campaign
3. Upload contacts via CSV:
   ```csv
   phone_number,name,custom_field
   1234567890,John Doe,value1
   0987654321,Jane Smith,value2
   ```
4. Configure campaign settings
5. Start the campaign

### Using the Dialer

1. Navigate to **Dialers**
2. Create a new dialer
3. Select type:
   - **Preview**: Agent previews contact before call
   - **Progressive**: Auto-dial when agent available
   - **Predictive**: AI-based predictive dialing
   - **Power**: Aggressive dialing strategy
4. Enable AI mode if desired
5. Start the dialer

### AI Integration

The system supports three AI modes:

1. **Human Mode**: Traditional call center operations
2. **AI Mode**: Fully automated AI-driven conversations
   - Uses OpenAI GPT models
   - Automatic speech recognition (mod_pocketsphinx)
   - Text-to-speech (mod_flite)
3. **Hybrid Mode**: Best of both worlds
   - AI handles initial interactions
   - Transfers to human when needed
   - Real-time AI assistance for agents

Configure in `.env`:
```env
AI_ENABLED=true
AI_MODE=hybrid
OPENAI_API_KEY=your_key
```

## FreeSWITCH Modules

### Required Modules
- **mod_esl**: Event Socket Library for API communication
- **mod_sofia**: SIP stack for call handling
- **mod_dialplan_xml**: XML dialplan processing
- **mod_db**: Database integration
- **mod_mariadb**: MariaDB connectivity

### Optional/Advanced Modules
- **mod_callcenter**: Queue and agent management
- **mod_conference**: Conference bridge functionality
- **mod_verto**: WebRTC video conferencing
- **mod_flite**: Text-to-speech engine
- **mod_pocketsphinx**: Speech recognition
- **mod_lcr**: Least cost routing
- **mod_nibblebill**: Real-time billing
- **mod_easyroute**: DID routing and management

## Architecture

### Database Schema

The system uses the following main tables:
- `users` - User accounts with roles
- `extensions` - SIP extensions
- `gateways` - SIP trunks/carriers
- `dids` - Inbound phone numbers
- `ivrs` - IVR menus
- `ring_groups` - Call distribution groups
- `queues` - Call center queues
- `queue_members` - Agent assignments
- `cdrs` - Call detail records
- `campaigns` - Voice/SMS campaigns
- `campaign_contacts` - Campaign recipients
- `conferences` - Video/audio conferences
- `dialers` - Dialer configurations
- `rate_tables` - Billing rates

### Technology Stack

**Backend:**
- Laravel 11
- PHP 8.2+
- MariaDB/MySQL
- Redis

**Frontend:**
- Vue.js 3
- Vite
- TailwindCSS
- Chart.js for analytics
- Socket.IO for real-time updates

**VoIP:**
- FreeSWITCH
- ESL (Event Socket Library)
- SIP/RTP protocols
- WebRTC (mod_verto)

## API Documentation

The panel provides a RESTful API for integration:

### Authentication
```bash
# Login
POST /api/login
{
  "email": "user@example.com",
  "password": "password"
}

# Returns JWT token for subsequent requests
```

### Extensions
```bash
# List extensions
GET /api/extensions

# Create extension
POST /api/extensions
{
  "extension": "1001",
  "password": "secure_password",
  "name": "John Doe"
}

# Update extension
PUT /api/extensions/1001

# Delete extension
DELETE /api/extensions/1001
```

### Live Calls
```bash
# Get active calls
GET /api/calls/live

# Hangup a call
POST /api/calls/{uuid}/hangup

# Originate a call
POST /api/calls/originate
{
  "extension": "1001",
  "destination": "1234567890"
}
```

### CDR
```bash
# Get call records
GET /api/cdr?from=2024-01-01&to=2024-01-31

# Get recording
GET /api/cdr/{id}/recording
```

## Security

### Best Practices

1. **Change Default Passwords**
   - FreeSWITCH ESL password
   - Database passwords
   - Extension passwords

2. **Enable Firewall**
   ```bash
   sudo ufw allow 22/tcp    # SSH
   sudo ufw allow 80/tcp    # HTTP
   sudo ufw allow 443/tcp   # HTTPS
   sudo ufw allow 5060/udp  # SIP
   sudo ufw allow 5061/tcp  # SIP TLS
   sudo ufw allow 16384:32768/udp  # RTP
   sudo ufw allow 8021/tcp  # ESL (localhost only recommended)
   sudo ufw enable
   ```

3. **SSL Certificate**
   ```bash
   sudo apt-get install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

4. **FreeSWITCH ACL**
   - Configure IP restrictions in FreeSWITCH ACL
   - Limit ESL access to localhost or trusted IPs

5. **Regular Updates**
   ```bash
   sudo apt-get update && sudo apt-get upgrade
   composer update
   npm update
   ```

## Troubleshooting

### FreeSWITCH Not Starting
```bash
# Check status
sudo systemctl status freeswitch

# View logs
sudo tail -f /var/log/freeswitch/freeswitch.log

# Test configuration
sudo freeswitch -nc -nonat
```

### Database Connection Issues
```bash
# Test database connection
mysql -u voipuser -p voip_panel

# Check Laravel database config
php artisan config:clear
php artisan migrate:status
```

### ESL Connection Failed
```bash
# Test ESL connection
fs_cli -H 127.0.0.1 -P ClueCon

# Check if FreeSWITCH is listening
netstat -an | grep 8021
```

### Web Interface Not Loading
```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM
sudo systemctl status php8.2-fpm

# View error logs
sudo tail -f /var/log/nginx/error.log
```

## Performance Tuning

### For High Volume Call Centers

1. **Database Optimization**
   ```sql
   -- Add indexes for frequently queried fields
   CREATE INDEX idx_cdr_start ON cdrs(start_stamp);
   CREATE INDEX idx_cdr_direction ON cdrs(direction);
   ```

2. **FreeSWITCH Optimization**
   - Increase `max-sessions` in switch.conf.xml
   - Optimize RTP port range
   - Enable core-db-dsn for better performance

3. **Laravel Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Redis Queue Workers**
   - Increase number of queue workers in supervisor config
   - Use Redis for session storage

## Support

For issues, questions, or contributions:
- GitHub Issues: [Link to issues]
- Documentation: [Link to docs]
- Community: [Link to community]

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Credits

- Laravel Framework
- FreeSWITCH
- SignalWire
- Vue.js
- All contributors

## Changelog

### Version 1.0.0
- Initial release
- Core VoIP features
- Call center functionality
- AI integration
- Video conferencing
- Campaign management
- Real-time monitoring
