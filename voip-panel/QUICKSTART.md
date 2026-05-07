# VoIP Panel - Quick Start Guide

## What is This?

This is a complete Laravel-based VoIP management panel designed to work with FreeSWITCH. It provides:

- **Web-based management** for your VoIP system
- **Call center features** with queues and agent management
- **AI-powered calling** with human, AI, and hybrid modes
- **Campaign management** for voice and SMS
- **Real-time monitoring** of active calls
- **Video conferencing** capabilities
- **Professional dialer** for call centers

## Quick Installation (Debian 11/12)

```bash
# 1. Get your SignalWire token from https://signalwire.com
export TOKEN=your_signalwire_token_here

# 2. Run the installation script
cd voip-panel
sudo chmod +x install.sh
sudo ./install.sh

# 3. Access the panel
# Open http://your-server-ip in a browser
```

That's it! The script installs everything:
- FreeSWITCH with all required modules
- MariaDB database
- Nginx web server
- PHP and all dependencies
- The VoIP panel application

## What Gets Installed

### FreeSWITCH Modules
- **mod_esl** - API communication
- **mod_sofia** - SIP handling
- **mod_callcenter** - Queue management
- **mod_conference** - Conference calls
- **mod_verto** - Video conferencing
- **mod_flite** - Text-to-speech
- **mod_pocketsphinx** - Speech recognition (AI)
- **mod_lcr** - Least cost routing
- **mod_nibblebill** - Real-time billing
- **mod_easyroute** - DID management
- **mod_mariadb** - Database integration

### Web Application
- Laravel 11 backend
- Vue.js 3 frontend
- Real-time dashboard
- REST API
- Role-based access control

## First Steps After Installation

### 1. Create Admin User
```bash
cd /var/www/voip-panel
php artisan tinker

# Then run:
use App\Models\User;
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'status' => 'active'
]);
exit
```

### 2. Login
- Go to http://your-server-ip
- Login with admin@example.com / password
- Change password immediately!

### 3. Create Your First Extension
1. Click **Extensions** in menu
2. Click **Add Extension**
3. Fill in:
   - Extension: 1001
   - Password: secure_password
   - Name: Test User
4. Click Save

### 4. Configure a SIP Trunk (Gateway)
1. Go to **Gateways**
2. Add gateway with your SIP provider details
3. Test by making an outbound call

### 5. Set Up a DID
1. Go to **DIDs**
2. Add your phone number
3. Set destination (extension, IVR, queue, etc.)

## Common Use Cases

### Call Center Setup
1. Create extensions for agents
2. Create a queue with strategy (e.g., longest-idle-agent)
3. Add agents to the queue
4. Point DID to the queue
5. Agents login and start receiving calls

### Voice Campaign
1. Go to **Campaigns**
2. Create new voice campaign
3. Upload audio message or use TTS
4. Import contacts from CSV
5. Schedule and start campaign

### IVR Menu
1. Go to **IVR Builder**
2. Create new IVR
3. Upload greeting or use TTS
4. Configure menu options (1 for sales, 2 for support, etc.)
5. Point DID to IVR

### Video Conference
1. Go to **Conferences**
2. Create conference room
3. Set PIN for security
4. Share conference number with participants
5. Participants dial the number or join via WebRTC

## Configuration Files

### Environment (.env)
```env
# FreeSWITCH Connection
FREESWITCH_HOST=127.0.0.1
FREESWITCH_ESL_PORT=8021
FREESWITCH_PASSWORD=ClueCon

# Database
DB_DATABASE=voip_panel
DB_USERNAME=voipuser
DB_PASSWORD=VoipP@ss123!

# AI Features (Optional)
AI_ENABLED=true
AI_MODE=hybrid
OPENAI_API_KEY=your_key_here
```

### FreeSWITCH Location
- Config: `/etc/freeswitch/`
- Recordings: `/var/lib/freeswitch/recordings/`
- Logs: `/var/log/freeswitch/`

## Troubleshooting

### Can't Connect to Panel
```bash
# Check Nginx
sudo systemctl status nginx
sudo systemctl restart nginx

# Check PHP-FPM
sudo systemctl status php8.2-fpm
```

### Can't Make Calls
```bash
# Check FreeSWITCH status
sudo systemctl status freeswitch

# View logs
sudo tail -f /var/log/freeswitch/freeswitch.log

# Test CLI
fs_cli
```

### Database Errors
```bash
# Check MariaDB
sudo systemctl status mariadb

# Test connection
mysql -u voipuser -p voip_panel
```

## Default Ports

- **80** - Web interface (HTTP)
- **443** - Web interface (HTTPS)
- **5060** - SIP (UDP)
- **5061** - SIP (TLS)
- **8021** - ESL (localhost only)
- **8082** - Verto WebSocket
- **16384-32768** - RTP media

## Security Recommendations

1. **Change default passwords**
   - Database password
   - FreeSWITCH ESL password
   - Admin panel password

2. **Enable firewall**
   ```bash
   sudo ufw allow 22/tcp
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw allow 5060/udp
   sudo ufw allow 16384:32768/udp
   sudo ufw enable
   ```

3. **Install SSL certificate**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com
   ```

4. **Restrict ESL access**
   - Keep port 8021 firewalled
   - Only accessible from localhost

## Getting Help

### Check Logs
```bash
# Application logs
tail -f /var/www/voip-panel/storage/logs/laravel.log

# FreeSWITCH logs
tail -f /var/log/freeswitch/freeswitch.log

# Nginx logs
tail -f /var/log/nginx/error.log
```

### Restart Services
```bash
sudo systemctl restart freeswitch
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

### Test FreeSWITCH
```bash
# Connect to CLI
fs_cli

# Show active calls
show channels

# Show registrations
show registrations

# Reload configuration
reloadxml
```

## Next Steps

1. Read the full [README.md](README.md) for detailed documentation
2. Check [PROJECT_OVERVIEW.md](PROJECT_OVERVIEW.md) for architecture details
3. Explore the web interface features
4. Configure your SIP trunks
5. Set up your first campaign
6. Enable AI features (optional)

## Support

- Documentation: See README.md
- Issues: GitHub Issues
- Configuration: Check .env file
- Logs: See troubleshooting section above

---

**Remember:** This is a powerful system. Start with basic features and gradually explore advanced capabilities like AI integration, video conferencing, and predictive dialers.
