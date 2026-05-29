# Installation Guide - FreeSWITCH PBX Full Functional System

## Quick Start

The PBX interface has been installed in the `htdocs/pbx` directory and is ready to use.

### Access the Interface

1. **Using FreeSWITCH Built-in Web Server**:
   ```
   http://your-freeswitch-server:8080/pbx/
   ```

2. **Default FreeSWITCH Installation**:
   ```
   http://localhost:8080/pbx/
   ```

### Prerequisites

- FreeSWITCH installed and running
- Web server enabled (built-in or external)
- Modern web browser (Chrome, Firefox, Safari, or Edge)

## Configuration

### Enable FreeSWITCH Web Server

Ensure `mod_xml_rpc` is loaded:

```bash
# Via fs_cli
fs_cli -x "load mod_xml_rpc"

# Or add to autoload_configs/modules.conf.xml
<load module="mod_xml_rpc"/>
```

### Configure Authentication

Default credentials are in:
```
/usr/local/freeswitch/conf/autoload_configs/xml_rpc.conf.xml
```

Example configuration:
```xml
<configuration name="xml_rpc.conf" description="XML RPC">
  <settings>
    <param name="http-port" value="8080"/>
    <param name="bind-address" value="0.0.0.0"/>
    <param name="auth-realm" value="freeswitch"/>
    <param name="auth-user" value="admin"/>
    <param name="auth-pass" value="your-secure-password"/>
  </settings>
</configuration>
```

### External Web Server Setup (Optional)

#### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName pbx.yourdomain.com
    DocumentRoot /usr/local/freeswitch/htdocs/pbx
    
    <Directory /usr/local/freeswitch/htdocs/pbx>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Proxy API requests to FreeSWITCH
    ProxyPass /api http://localhost:8080/api
    ProxyPassReverse /api http://localhost:8080/api
</VirtualHost>
```

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name pbx.yourdomain.com;
    
    root /usr/local/freeswitch/htdocs/pbx;
    index index.html;
    
    location / {
        try_files $uri $uri/ /index.html;
    }
    
    # Proxy API requests to FreeSWITCH
    location /api {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

## Features Overview

### Main Modules

1. **Dashboard**: System overview and real-time statistics
2. **Accounts**: User, extension, device, and gateway management
3. **Dialplan**: Call routing, IVR, queues, and voicemail configuration
4. **Call Center**: Agent management, call monitoring, and analytics
5. **Conferences**: Conference room and profile management
6. **Monitoring**: System health, logs, and performance metrics
7. **Billing**: Rate plans, invoicing, and payment tracking
8. **Recordings**: Call and voicemail recording management
9. **System**: SIP profiles, settings, backup, and restore

### Navigation

- **Sidebar Menu**: Click on menu items to expand sub-menus
- **Mobile Support**: Use hamburger menu icon on mobile devices
- **Breadcrumbs**: Page title updates to show current location
- **Direct URLs**: Use hash navigation (e.g., `#accounts-users`)

## Customization

### Branding

Edit `/htdocs/pbx/css/style.css` to customize colors:

```css
:root {
    --primary-color: #2c3e50;      /* Main theme color */
    --secondary-color: #3498db;     /* Accent color */
    --sidebar-bg: #16213e;          /* Sidebar background */
}
```

### Logo

Replace the sidebar title in `/htdocs/pbx/index.html`:

```html
<div class="sidebar-header">
    <h2><i class="fas fa-phone-volume"></i> Your Company Name</h2>
</div>
```

## API Integration

The system includes an API client for backend integration.

### Include API Client

```html
<script src="api/client.js"></script>
```

### Use API Client

```javascript
// Get dashboard statistics
pbxApi.getDashboardStats().then(stats => {
    console.log('Active calls:', stats.activeCalls);
});

// Get users
pbxApi.getUsers().then(users => {
    console.log('Users:', users);
});

// WebSocket for real-time updates
const ws = pbxApi.connectWebSocket(
    (data) => {
        console.log('Update:', data);
    },
    (error) => {
        console.error('WebSocket error:', error);
    }
);
```

## Security Best Practices

1. **Change Default Credentials**: Update XML-RPC authentication
2. **Use HTTPS**: Configure SSL/TLS certificates
3. **Firewall Rules**: Restrict access to trusted IPs
4. **Regular Updates**: Keep FreeSWITCH updated
5. **Access Control**: Implement user authentication
6. **Backup**: Regular system backups via the Backup module

## Troubleshooting

### Cannot Access Interface

1. Check FreeSWITCH is running:
   ```bash
   ps aux | grep freeswitch
   ```

2. Verify web server is listening:
   ```bash
   netstat -tlnp | grep 8080
   ```

3. Check file permissions:
   ```bash
   ls -la /usr/local/freeswitch/htdocs/pbx/
   ```

### 403 Forbidden Error

1. Check web server configuration
2. Verify file permissions (should be readable by web server)
3. Check SELinux settings (if applicable)

### API Connection Failed

1. Verify mod_xml_rpc is loaded:
   ```bash
   fs_cli -x "module_exists mod_xml_rpc"
   ```

2. Check XML-RPC configuration
3. Verify authentication credentials

## Support

- **FreeSWITCH Documentation**: https://freeswitch.org/confluence/
- **Community**: https://signalwire.community/
- **Issue Tracker**: https://github.com/signalwire/freeswitch/issues

## File Locations

- **Application**: `/usr/local/freeswitch/htdocs/pbx/`
- **Configuration**: `/usr/local/freeswitch/conf/`
- **Logs**: `/usr/local/freeswitch/log/`
- **Recordings**: `/usr/local/freeswitch/recordings/`

## Performance Tips

1. **Browser Cache**: Enable caching for static files
2. **CDN**: Use CDN for Font Awesome (already configured)
3. **Compression**: Enable gzip compression on web server
4. **Minimize Requests**: Combine CSS/JS files for production

## Development

### Local Development

```bash
cd /usr/local/freeswitch/htdocs/pbx
python3 -m http.server 8000
```

Then access: `http://localhost:8000/`

### Directory Structure

```
pbx/
├── index.html          # Main application file
├── css/
│   └── style.css      # Application styles
├── js/
│   └── app.js         # Application logic
├── api/
│   └── client.js      # API client library
└── README.md          # Documentation
```

## License

This PBX interface follows the FreeSWITCH MPL 1.1 license.

## Version

**Version 1.0.0** - Full Functional PBX System
Released: February 2024
