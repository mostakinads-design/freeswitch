# VoIP Panel - Project Overview

## Project Structure

```
voip-panel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/           # REST API Controllers
│   ├── Models/                 # Eloquent Models
│   └── Services/               # Business Logic Services
│       └── FreeSwitchESLService.php
├── config/
│   └── freeswitch.php         # FreeSWITCH Configuration
├── database/
│   ├── migrations/             # Database Schema
│   └── seeders/                # Database Seeders
├── freeswitch-config/          # FreeSWITCH XML Templates
│   ├── dialplan/               # Dialplan configurations
│   ├── directory/              # User/Extension templates
│   ├── sip_profiles/           # SIP Gateway templates
│   └── autoload_configs/       # Module configurations
├── public/                     # Web root
├── resources/
│   ├── js/
│   │   ├── components/         # Vue Components
│   │   ├── pages/              # Vue Pages
│   │   ├── services/           # Frontend Services
│   │   ├── App.vue             # Main Vue App
│   │   ├── router.js           # Vue Router
│   │   └── app.js              # Entry Point
│   └── views/                  # Blade Templates
├── routes/
│   └── api.php                 # API Routes
├── storage/                    # File Storage
├── tests/                      # Unit/Feature Tests
├── .env.example                # Environment Template
├── composer.json               # PHP Dependencies
├── package.json                # Node.js Dependencies
├── vite.config.js              # Vite Build Config
├── install.sh                  # Installation Script
└── README.md                   # Documentation
```

## Key Components

### Backend (Laravel)

#### Models
- **User**: User accounts with role-based access (admin/agent/user)
- **Extension**: SIP extensions for users
- **Gateway**: SIP trunk/carrier configurations
- **DID**: Inbound phone numbers with routing
- **IVR**: Interactive Voice Response menus
- **RingGroup**: Call distribution groups
- **Queue**: Call center queues
- **Campaign**: Voice/SMS campaigns
- **CampaignContact**: Campaign recipients
- **CDR**: Call Detail Records
- **Conference**: Video/audio conferences
- **Dialer**: Auto-dialer configurations
- **RateTable**: Billing rate tables

#### Services
- **FreeSwitchESLService**: Event Socket Library integration
  - Connect to FreeSWITCH
  - Execute commands
  - Manage calls
  - Get real-time status

#### Controllers
- **DashboardController**: Statistics and overview
- **ExtensionController**: Extension CRUD + FreeSWITCH sync
- **CallController**: Live call management
- **CampaignController**: Campaign management
- **CDRController**: Call records
- And more...

### Frontend (Vue.js 3)

#### Pages
- **Dashboard**: Real-time statistics and live calls
- **Extensions**: Extension management
- **DIDs**: DID configuration
- **IVR Builder**: Visual IVR designer
- **Queues**: Queue management
- **Campaigns**: Campaign management with CSV upload
- **CDR**: Call records viewer
- **AgentDashboard**: Agent interface
- **Conferences**: Video conference management
- **Login**: Authentication

#### Features
- Real-time updates (2-second refresh)
- Responsive design with TailwindCSS
- Modern UI/UX
- AJAX API calls
- WebSocket support (planned)

### FreeSWITCH Integration

#### Configuration Templates
1. **Dialplan** (`dialplan/default.xml`)
   - Local extension routing
   - DID routing
   - IVR routing
   - Ring group routing
   - Queue routing
   - Conference routing
   - Outbound routing with LCR

2. **Directory** (`directory/user_template.xml`)
   - User/extension configuration
   - Voicemail settings
   - Caller ID
   - Variables

3. **SIP Profiles** (`sip_profiles/gateway_template.xml`)
   - Gateway configuration
   - Authentication
   - Registration

4. **Module Configs**
   - `callcenter.conf.xml` - Queue configuration
   - `db.conf.xml` - Database connectivity
   - `verto.conf.xml` - Video conferencing

### Database Schema

#### Core Tables
- `users` - User accounts
- `extensions` - SIP extensions
- `gateways` - SIP trunks
- `dids` - Phone numbers
- `ivrs` - IVR menus
- `ring_groups` - Distribution groups

#### Call Center Tables
- `queues` - Call queues
- `queue_members` - Agent assignments
- `dialers` - Dialer configurations

#### Tracking Tables
- `cdrs` - Call records
- `campaigns` - Voice/SMS campaigns
- `campaign_contacts` - Campaign recipients
- `rate_tables` - Billing rates

#### Communication Tables
- `conferences` - Conference rooms

## Features Implementation

### 1. Extension Management
- Create/Update/Delete extensions
- Auto-sync to FreeSWITCH
- Voicemail configuration
- Caller ID settings

### 2. DID Routing
- Multiple destination types:
  - Extension
  - IVR
  - Ring Group
  - Queue
  - Conference
  - External number

### 3. IVR System
- Text-to-Speech support
- Audio file uploads
- Configurable menu options
- Timeout handling
- Failure actions

### 4. Call Queues
- Multiple strategies:
  - Ring-all
  - Longest idle agent
  - Round-robin
  - Top-down
  - Agent with least talk time
  - Sequential by agent order
- Tier rules
- Call recording
- Music on hold

### 5. Campaigns
- Voice campaigns with audio files
- SMS campaigns
- CSV contact import
- Progress tracking
- Scheduled execution

### 6. Dialers
- Preview: Agent previews before call
- Progressive: Auto-dial when available
- Predictive: AI-based prediction
- Power: Aggressive dialing
- AMD (Answering Machine Detection)
- AI integration

### 7. AI Features
Three modes:
- **Human**: Traditional agent handling
- **AI**: Fully automated with OpenAI
- **Hybrid**: AI assistance with human oversight

Technologies:
- mod_pocketsphinx: Speech recognition
- mod_flite: Text-to-speech
- OpenAI API: Natural language processing

### 8. Video Conferencing
- mod_verto integration
- WebRTC support
- PIN protection
- Recording capability
- Max participants control

### 9. Billing System
- mod_nibblebill integration
- Per-minute rates
- Area code-based pricing
- Connection fees
- Minimum/increment seconds

### 10. LCR (Least Cost Routing)
- mod_lcr integration
- Automatic carrier selection
- Cost optimization
- Failover support

## API Endpoints

### Authentication
- `POST /api/login` - Login
- `POST /api/logout` - Logout

### Dashboard
- `GET /api/dashboard/stats` - Statistics

### Extensions
- `GET /api/extensions` - List
- `POST /api/extensions` - Create
- `GET /api/extensions/{id}` - Show
- `PUT /api/extensions/{id}` - Update
- `DELETE /api/extensions/{id}` - Delete
- `POST /api/extensions/{id}/sync` - Sync to FreeSWITCH

### DIDs
- `GET /api/dids` - List
- `POST /api/dids` - Create
- (CRUD operations similar to extensions)

### Live Calls
- `GET /api/calls/live` - Active calls
- `POST /api/calls/{uuid}/hangup` - Hangup call
- `POST /api/calls/originate` - Make call

### CDR
- `GET /api/cdr` - Call records
- `GET /api/cdr/{id}` - Single record
- `GET /api/cdr/{id}/recording` - Get recording

### Campaigns
- `GET /api/campaigns` - List
- `POST /api/campaigns` - Create
- `POST /api/campaigns/{id}/contacts/import` - Import CSV
- `POST /api/campaigns/{id}/start` - Start campaign
- `POST /api/campaigns/{id}/pause` - Pause campaign

## Installation Requirements

### System Requirements
- Debian 11/12
- 4GB+ RAM (8GB recommended)
- 20GB+ disk space
- Network connectivity

### Software Requirements
- PHP 8.2+
- MariaDB/MySQL 10.5+
- Nginx/Apache
- Redis
- Node.js 18+
- Composer
- FreeSWITCH (via SignalWire)

### Required FreeSWITCH Modules
- mod_esl
- mod_sofia
- mod_dialplan_xml
- mod_commands
- mod_db
- mod_dptools
- mod_callcenter
- mod_conference
- mod_verto
- mod_flite
- mod_pocketsphinx
- mod_lcr
- mod_nibblebill
- mod_easyroute
- mod_mariadb
- mod_odbc_cdr

## Security Considerations

1. **Authentication**
   - JWT tokens for API
   - Role-based access control
   - Password hashing

2. **FreeSWITCH**
   - ACL restrictions
   - ESL password protection
   - SIP authentication

3. **Network**
   - Firewall configuration
   - SSL/TLS encryption
   - Secure WebSocket

4. **Database**
   - Prepared statements
   - Input validation
   - SQL injection protection

## Performance Optimization

1. **Caching**
   - Redis for sessions
   - Config caching
   - Route caching
   - View caching

2. **Queue Workers**
   - Supervisor management
   - Multiple workers
   - Job batching

3. **Database**
   - Proper indexing
   - Query optimization
   - Connection pooling

4. **FreeSWITCH**
   - Session limits
   - RTP optimization
   - Core-db-dsn

## Future Enhancements

1. **Advanced Features**
   - WebRTC softphone
   - Real-time analytics
   - Call sentiment analysis
   - Advanced reporting

2. **Integrations**
   - CRM integration
   - WhatsApp/Telegram
   - Email notifications
   - Webhook support

3. **AI Improvements**
   - Voice cloning
   - Real-time translation
   - Advanced NLP
   - Predictive analytics

4. **Scalability**
   - Multi-server support
   - Load balancing
   - Distributed queues
   - Microservices architecture

## Support and Maintenance

### Monitoring
- System health checks
- FreeSWITCH status
- Queue lengths
- Call quality metrics

### Backups
- Database backups
- Configuration backups
- Recording backups
- CDR archival

### Updates
- Security patches
- Feature updates
- Bug fixes
- Module updates

## Conclusion

This VoIP panel provides a comprehensive solution for:
- Small to large call centers
- Enterprise telephony
- Customer service operations
- Sales and marketing campaigns
- AI-powered voice systems

The modular architecture allows for easy customization and scaling based on specific business needs.
