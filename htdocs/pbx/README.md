# FreeSWITCH PBX - Full Functional System

A comprehensive web-based PBX management system for FreeSWITCH with a complete feature set for managing telecommunications infrastructure.

## Features

### Dashboard
- Real-time system statistics
- Active calls monitoring
- System health overview
- Recent activity feed

### Accounts Management
- **Users**: Complete user account management
- **Extensions**: SIP extension configuration
- **Devices**: IP phone and device registration
- **Gateways**: SIP trunk and gateway management
- **Domains**: Multi-domain support
- **Group Manager**: User group organization

### Dialplan
- **Destinations**: Call destination management
- **Inbound Routes**: DID routing configuration
- **Outbound Routes**: Carrier selection and routing
- **Dialplan Manager**: Advanced dialplan editing
- **Call Flows**: Visual call flow designer
- **IVR Menus**: Interactive voice response systems
- **Ring Groups**: Simultaneous and sequential ringing
- **Queues**: Advanced call queue management
- **Time Conditions**: Time-based routing
- **Follow Me**: Find me/follow me features
- **Call Forward**: Call forwarding rules
- **Music On Hold**: MOH management
- **Voicemail**: Voicemail system configuration
- **Emergency Routes**: E911 routing
- **Number Translation**: Number manipulation rules

### Call Center
- **Active Calls**: Real-time call monitoring
- **Active Agents**: Agent status dashboard
- **Queues Monitor**: Queue performance metrics
- **Agent Status**: Agent availability management
- **Call Broadcast**: Mass calling campaigns
- **Call Recordings**: Recording management
- **Call Logs (CDR)**: Call detail records
- **Call Analytics**: Performance analytics
- **Real-Time Monitor**: Live monitoring dashboard

### Conferences
- **Conference Rooms**: Virtual conference rooms
- **Conference Profiles**: Audio/video profiles
- **Live Conferences**: Active conference monitoring

### Monitoring
- **Active Calls**: System-wide call monitoring
- **Call Statistics**: Performance metrics
- **Device Logs**: Device activity logs
- **Emergency Logs**: Emergency call tracking
- **Event Guard**: Security event monitoring
- **System Health**: Server health metrics

### Billing
- **Rate Plans**: Call rating configuration
- **Call Costing**: Cost analysis
- **Client Billing**: Customer account management
- **Invoices**: Invoice generation
- **Payments**: Payment tracking

### Recordings
- **Call Recordings**: Call recording management
- **Voicemail Recordings**: Voicemail message management

### System
- **SIP Profiles**: SIP profile configuration
- **Access Control**: User permissions and security
- **FreeSWITCH Settings**: Core system settings
- **API Manager**: REST API management
- **Logs Viewer**: System log viewer
- **Backup & Restore**: System backup and restore

## Installation

### Prerequisites
- FreeSWITCH installed and running
- Web server (built-in FreeSWITCH web server or external)
- Modern web browser (Chrome, Firefox, Safari, Edge)

### Setup

1. The PBX interface is located in the `htdocs/pbx` directory of your FreeSWITCH installation.

2. Access the interface through your web browser:
   ```
   http://your-freeswitch-server:8080/pbx/
   ```

3. For external web server (Apache/Nginx), configure a virtual host to serve the `htdocs/pbx` directory.

### Configuration

The system uses the FreeSWITCH XML-RPC interface for communication. Ensure mod_xml_rpc is loaded:

```bash
fs_cli -x "load mod_xml_rpc"
```

Default credentials are configured in `/usr/local/freeswitch/conf/autoload_configs/xml_rpc.conf.xml`.

## Usage

### Navigation
- Use the left sidebar to navigate between different modules
- Click on menu items to expand sub-sections
- The main content area displays the selected module

### Features
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Real-time Updates**: Dashboard shows live system statistics
- **Intuitive Interface**: Clean, modern design for easy navigation
- **Comprehensive Coverage**: All major PBX features in one interface

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Icons**: Font Awesome 6
- **Design**: Responsive, modern UI with gradient themes
- **Backend**: FreeSWITCH XML-RPC API

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Modern mobile browsers

## Security Notes

- Change default credentials before production use
- Use HTTPS for secure communication
- Implement proper access control
- Regular backups are recommended
- Keep FreeSWITCH updated

## Development

### File Structure
```
pbx/
├── index.html          # Main application file
├── css/
│   └── style.css      # Application styles
├── js/
│   └── app.js         # Application logic
└── api/               # API integration (future)
```

### Customization

The system can be customized by:
- Modifying CSS variables in `style.css`
- Extending content templates in `app.js`
- Adding new menu items in `index.html`

## API Integration

The system is designed to integrate with:
- FreeSWITCH Event Socket
- FreeSWITCH XML-RPC
- Custom backend APIs

## Support

For support and contributions:
- FreeSWITCH Documentation: https://freeswitch.org/confluence/
- FreeSWITCH Community: https://signalwire.community/

## License

This PBX interface follows the FreeSWITCH MPL 1.1 license.

## Credits

Built for FreeSWITCH - The World's First Cross-Platform Scalable FREE Multi-Protocol Soft Switch

## Version

Version 1.0.0 - Full Functional PBX System
