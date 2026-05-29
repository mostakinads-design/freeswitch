// ===== PBX Application JavaScript =====

// Content templates for each section
const contentTemplates = {
    dashboard: `
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-phone-volume"></i>
                </div>
                <div class="stat-info">
                    <h3>156</h3>
                    <p>Active Calls</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>89</h3>
                    <p>Active Users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="stat-info">
                    <h3>24</h3>
                    <p>Active Agents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-network-wired"></i>
                </div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Gateways</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-chart-line"></i> System Overview</h2>
            </div>
            <div class="card-body">
                <p>Welcome to FreeSWITCH PBX - Full Functional System</p>
                <p>This comprehensive PBX system provides complete control over your telecommunications infrastructure.</p>
            </div>
        </div>

        <div class="charts-row">
            <div class="card">
                <div class="card-header">
                    <h2>Recent Activity</h2>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10:45 AM</td>
                                    <td>New user registered</td>
                                    <td><span class="badge-status active">Success</span></td>
                                </tr>
                                <tr>
                                    <td>10:30 AM</td>
                                    <td>Gateway connected</td>
                                    <td><span class="badge-status active">Connected</span></td>
                                </tr>
                                <tr>
                                    <td>10:15 AM</td>
                                    <td>System backup completed</td>
                                    <td><span class="badge-status active">Complete</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>System Health</h2>
                </div>
                <div class="card-body">
                    <div style="margin: 20px 0;">
                        <div style="margin-bottom: 15px;">
                            <strong>CPU Usage:</strong> <span style="color: var(--success-color);">45%</span>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>Memory Usage:</strong> <span style="color: var(--warning-color);">68%</span>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>Disk Space:</strong> <span style="color: var(--success-color);">32%</span>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>Network:</strong> <span style="color: var(--success-color);">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `,

    'accounts-users': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user"></i> User Management</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add User</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Extension</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>john.doe</td>
                                <td>john@example.com</td>
                                <td>1001</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" style="padding: 5px 10px;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>jane.smith</td>
                                <td>jane@example.com</td>
                                <td>1002</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" style="padding: 5px 10px;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'accounts-extensions': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-phone"></i> Extensions</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Extension</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Extension</th>
                                <th>User</th>
                                <th>Device</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1001</td>
                                <td>John Doe</td>
                                <td>Yealink T46S</td>
                                <td><span class="badge-status active">Registered</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'accounts-devices': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-mobile-alt"></i> Devices</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Device</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Device Name</th>
                                <th>Type</th>
                                <th>MAC Address</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Yealink T46S</td>
                                <td>IP Phone</td>
                                <td>00:15:65:4D:C2:45</td>
                                <td>192.168.1.101</td>
                                <td><span class="badge-status active">Online</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'accounts-gateways': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-network-wired"></i> Gateways</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Gateway</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Gateway Name</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th>Channels</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SIP Trunk 1</td>
                                <td>VoIP Provider</td>
                                <td><span class="badge-status active">Connected</span></td>
                                <td>0/30</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'accounts-domains': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-globe"></i> Domains</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Domain</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Domain Name</th>
                                <th>Description</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>pbx.example.com</td>
                                <td>Main PBX Domain</td>
                                <td>45</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'accounts-groups': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users-cog"></i> Group Manager</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Group</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Description</th>
                                <th>Members</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sales Team</td>
                                <td>Sales department members</td>
                                <td>12</td>
                                <td>Standard</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-destinations': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-map-marker-alt"></i> Destinations</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Destination</button>
            </div>
            <div class="card-body">
                <p>Manage call destinations and routing targets.</p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Destination</th>
                                <th>Type</th>
                                <th>Target</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Main Reception</td>
                                <td>Extension</td>
                                <td>1000</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-inbound': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-arrow-down"></i> Inbound Routes</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Route</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>DID/Number</th>
                                <th>Description</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>+1234567890</td>
                                <td>Main Line</td>
                                <td>IVR Menu 1</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-outbound': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-arrow-up"></i> Outbound Routes</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Route</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Route Name</th>
                                <th>Pattern</th>
                                <th>Gateway</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Local Calls</td>
                                <td>^\\d{7}$</td>
                                <td>Gateway 1</td>
                                <td>1</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-manager': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cogs"></i> Dialplan Manager</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Dialplan</button>
            </div>
            <div class="card-body">
                <p>Advanced dialplan configuration and management.</p>
            </div>
        </div>
    `,

    'dialplan-callflows': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-route"></i> Call Flows</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Call Flow</button>
            </div>
            <div class="card-body">
                <p>Visual call flow designer for complex routing scenarios.</p>
            </div>
        </div>
    `,

    'dialplan-ivr': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-list-ol"></i> IVR Menus</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add IVR Menu</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>IVR Name</th>
                                <th>Extension</th>
                                <th>Options</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Main Menu</td>
                                <td>5000</td>
                                <td>5 Options</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-ringgroups': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-ring"></i> Ring Groups</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Ring Group</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Extension</th>
                                <th>Strategy</th>
                                <th>Members</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Support Team</td>
                                <td>6000</td>
                                <td>Round Robin</td>
                                <td>5</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-queues': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-users-between-lines"></i> Call Queues</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Queue</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Queue Name</th>
                                <th>Extension</th>
                                <th>Waiting</th>
                                <th>Agents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Customer Support</td>
                                <td>7000</td>
                                <td>3</td>
                                <td>8/12</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-timeconditions': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-clock"></i> Time Conditions</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Time Condition</button>
            </div>
            <div class="card-body">
                <p>Configure time-based routing rules for calls.</p>
            </div>
        </div>
    `,

    'dialplan-followme': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-shoe-prints"></i> Follow Me</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Follow Me</button>
            </div>
            <div class="card-body">
                <p>Configure follow me settings for users.</p>
            </div>
        </div>
    `,

    'dialplan-forward': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-forward"></i> Call Forward</h2>
            </div>
            <div class="card-body">
                <p>Manage call forwarding rules and settings.</p>
            </div>
        </div>
    `,

    'dialplan-moh': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-music"></i> Music On Hold</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add MOH</button>
            </div>
            <div class="card-body">
                <p>Manage music on hold files and playlists.</p>
            </div>
        </div>
    `,

    'dialplan-voicemail': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-voicemail"></i> Voicemail</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mailbox</th>
                                <th>User</th>
                                <th>Messages</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1001</td>
                                <td>John Doe</td>
                                <td>3 New / 12 Old</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-play"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'dialplan-emergency': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Emergency Routes</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Emergency Route</button>
            </div>
            <div class="card-body">
                <p>Configure emergency calling (E911) routes and settings.</p>
            </div>
        </div>
    `,

    'dialplan-translation': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-exchange-alt"></i> Number Translation</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Translation</button>
            </div>
            <div class="card-body">
                <p>Configure number manipulation and translation rules.</p>
            </div>
        </div>
    `,

    'callcenter-active': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-phone-volume"></i> Active Calls</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Caller ID</th>
                                <th>Destination</th>
                                <th>Agent</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>+1234567890</td>
                                <td>1001</td>
                                <td>John Doe</td>
                                <td>00:03:45</td>
                                <td><span class="badge-status active">Connected</span></td>
                                <td>
                                    <button class="btn btn-warning" style="padding: 5px 10px;"><i class="fas fa-pause"></i></button>
                                    <button class="btn btn-danger" style="padding: 5px 10px;"><i class="fas fa-phone-slash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'callcenter-agents': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-headset"></i> Active Agents</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Extension</th>
                                <th>Status</th>
                                <th>Current Call</th>
                                <th>Total Calls</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>1001</td>
                                <td><span class="badge-status active">Available</span></td>
                                <td>-</td>
                                <td>45</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-info"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'callcenter-monitor': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-tv"></i> Queues Monitor</h2>
            </div>
            <div class="card-body">
                <p>Real-time monitoring of call queues and performance metrics.</p>
            </div>
        </div>
    `,

    'callcenter-status': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-info-circle"></i> Agent Status</h2>
            </div>
            <div class="card-body">
                <p>View and manage agent availability and status.</p>
            </div>
        </div>
    `,

    'callcenter-broadcast': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-bullhorn"></i> Call Broadcast</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> New Broadcast</button>
            </div>
            <div class="card-body">
                <p>Schedule and manage mass calling campaigns.</p>
            </div>
        </div>
    `,

    'callcenter-recordings': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-microphone"></i> Call Recordings</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Caller</th>
                                <th>Agent</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-02-18 10:30</td>
                                <td>+1234567890</td>
                                <td>John Doe</td>
                                <td>00:15:30</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-play"></i></button>
                                    <button class="btn btn-success" style="padding: 5px 10px;"><i class="fas fa-download"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'callcenter-cdr': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file-alt"></i> Call Detail Records (CDR)</h2>
                <button class="btn btn-success"><i class="fas fa-download"></i> Export</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Caller</th>
                                <th>Destination</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-02-18 10:45</td>
                                <td>+1234567890</td>
                                <td>1001</td>
                                <td>00:05:30</td>
                                <td><span class="badge-status active">Answered</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'callcenter-analytics': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-chart-line"></i> Call Analytics</h2>
            </div>
            <div class="card-body">
                <p>Comprehensive call analytics and reporting dashboard.</p>
            </div>
        </div>
    `,

    'callcenter-realtime': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-desktop"></i> Real-Time Monitor</h2>
            </div>
            <div class="card-body">
                <p>Live call center monitoring with real-time statistics.</p>
            </div>
        </div>
    `,

    'conferences-rooms': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-door-open"></i> Conference Rooms</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Room</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Name</th>
                                <th>PIN</th>
                                <th>Participants</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3000</td>
                                <td>Main Conference</td>
                                <td>****</td>
                                <td>0/50</td>
                                <td><span class="badge-status inactive">Inactive</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'conferences-profiles': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-sliders-h"></i> Conference Profiles</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Profile</button>
            </div>
            <div class="card-body">
                <p>Manage conference room profiles and settings.</p>
            </div>
        </div>
    `,

    'conferences-live': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-broadcast-tower"></i> Live Conferences</h2>
            </div>
            <div class="card-body">
                <p>Monitor active conference rooms and participants.</p>
            </div>
        </div>
    `,

    'monitoring-calls': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-phone-alt"></i> Active Calls Monitoring</h2>
            </div>
            <div class="card-body">
                <p>Real-time monitoring of all active calls in the system.</p>
            </div>
        </div>
    `,

    'monitoring-stats': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-chart-bar"></i> Call Statistics</h2>
            </div>
            <div class="card-body">
                <p>Detailed call statistics and performance metrics.</p>
            </div>
        </div>
    `,

    'monitoring-devices': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-hdd"></i> Device Logs</h2>
            </div>
            <div class="card-body">
                <p>Device registration and activity logs.</p>
            </div>
        </div>
    `,

    'monitoring-emergency': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-ambulance"></i> Emergency Logs</h2>
            </div>
            <div class="card-body">
                <p>Emergency call logs and E911 activity.</p>
            </div>
        </div>
    `,

    'monitoring-eventguard': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-shield-alt"></i> Event Guard</h2>
            </div>
            <div class="card-body">
                <p>Security monitoring and event detection.</p>
            </div>
        </div>
    `,

    'monitoring-health': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-heartbeat"></i> System Health</h2>
            </div>
            <div class="card-body">
                <div style="margin: 20px 0;">
                    <h3>Server Status</h3>
                    <div style="margin: 15px 0;">
                        <strong>Uptime:</strong> 15 days, 7 hours
                    </div>
                    <div style="margin: 15px 0;">
                        <strong>CPU Load:</strong> <span style="color: var(--success-color);">45%</span>
                    </div>
                    <div style="margin: 15px 0;">
                        <strong>Memory Usage:</strong> <span style="color: var(--warning-color);">68%</span>
                    </div>
                    <div style="margin: 15px 0;">
                        <strong>Disk Usage:</strong> <span style="color: var(--success-color);">32%</span>
                    </div>
                    <div style="margin: 15px 0;">
                        <strong>Network Status:</strong> <span style="color: var(--success-color);">Healthy</span>
                    </div>
                </div>
            </div>
        </div>
    `,

    'billing-rates': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-tags"></i> Rate Plans</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Rate Plan</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Rate per Minute</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Standard Plan</td>
                                <td>$0.05</td>
                                <td>USD</td>
                                <td><span class="badge-status active">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'billing-costing': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-calculator"></i> Call Costing</h2>
            </div>
            <div class="card-body">
                <p>View and analyze call costs and billing calculations.</p>
            </div>
        </div>
    `,

    'billing-clients': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-tie"></i> Client Billing</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Client</button>
            </div>
            <div class="card-body">
                <p>Manage client accounts and billing information.</p>
            </div>
        </div>
    `,

    'billing-invoices': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-receipt"></i> Invoices</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Create Invoice</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#INV-001</td>
                                <td>ABC Corp</td>
                                <td>$250.00</td>
                                <td>2024-02-15</td>
                                <td><span class="badge-status pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'billing-payments': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-credit-card"></i> Payments</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#PAY-001</td>
                                <td>ABC Corp</td>
                                <td>$250.00</td>
                                <td>Credit Card</td>
                                <td>2024-02-16</td>
                                <td><span class="badge-status active">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'recordings-calls': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file-audio"></i> Call Recordings</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Caller</th>
                                <th>Extension</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-02-18 10:30</td>
                                <td>+1234567890</td>
                                <td>1001</td>
                                <td>00:15:30</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-play"></i></button>
                                    <button class="btn btn-success" style="padding: 5px 10px;"><i class="fas fa-download"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'recordings-voicemail': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-envelope-open-text"></i> Voicemail Recordings</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mailbox</th>
                                <th>From</th>
                                <th>Date/Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1001</td>
                                <td>+1234567890</td>
                                <td>2024-02-18 09:15</td>
                                <td>00:01:45</td>
                                <td><span class="badge-status pending">New</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-play"></i></button>
                                    <button class="btn btn-success" style="padding: 5px 10px;"><i class="fas fa-download"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'system-sip': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-phone-square"></i> SIP Profiles</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Profile</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Profile Name</th>
                                <th>Port</th>
                                <th>Status</th>
                                <th>Registrations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Internal</td>
                                <td>5060</td>
                                <td><span class="badge-status active">Running</span></td>
                                <td>45</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'system-access': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-lock"></i> Access Control</h2>
            </div>
            <div class="card-body">
                <p>Manage user access permissions and security settings.</p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Last Access</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>admin</td>
                                <td>Administrator</td>
                                <td>Full Access</td>
                                <td>2024-02-18 11:00</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px;"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,

    'system-settings': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-wrench"></i> FreeSWITCH Settings</h2>
                <button class="btn btn-success"><i class="fas fa-save"></i> Save Settings</button>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label>Default Caller ID</label>
                        <input type="text" placeholder="Default Caller ID">
                    </div>
                    <div class="form-group">
                        <label>Max Call Duration (seconds)</label>
                        <input type="number" placeholder="3600">
                    </div>
                    <div class="form-group">
                        <label>Recording Path</label>
                        <input type="text" placeholder="/var/lib/freeswitch/recordings">
                    </div>
                </form>
            </div>
        </div>
    `,

    'system-api': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-code"></i> API Manager</h2>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Create API Key</button>
            </div>
            <div class="card-body">
                <p>Manage API keys and webhook configurations.</p>
            </div>
        </div>
    `,

    'system-logs': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file-medical-alt"></i> Logs Viewer</h2>
                <button class="btn btn-primary"><i class="fas fa-sync"></i> Refresh</button>
            </div>
            <div class="card-body">
                <div style="background: #000; color: #0f0; padding: 20px; font-family: monospace; height: 400px; overflow-y: auto;">
                    <div>[2024-02-18 11:00:15] System started</div>
                    <div>[2024-02-18 11:00:16] Loading modules...</div>
                    <div>[2024-02-18 11:00:17] Module mod_sofia loaded</div>
                    <div>[2024-02-18 11:00:18] Module mod_event_socket loaded</div>
                    <div>[2024-02-18 11:00:19] All modules loaded successfully</div>
                </div>
            </div>
        </div>
    `,

    'system-backup': `
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-database"></i> Backup & Restore</h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 30px;">
                    <h3>Create Backup</h3>
                    <button class="btn btn-success"><i class="fas fa-download"></i> Backup Now</button>
                </div>
                <div>
                    <h3>Available Backups</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Backup Name</th>
                                    <th>Date</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>backup_2024_02_18.tar.gz</td>
                                    <td>2024-02-18 08:00</td>
                                    <td>245 MB</td>
                                    <td>
                                        <button class="btn btn-success" style="padding: 5px 10px;"><i class="fas fa-download"></i></button>
                                        <button class="btn btn-warning" style="padding: 5px 10px;"><i class="fas fa-undo"></i> Restore</button>
                                        <button class="btn btn-danger" style="padding: 5px 10px;"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `
};

// Page titles mapping
const pageTitles = {
    'dashboard': 'Dashboard',
    'accounts-users': 'User Management',
    'accounts-extensions': 'Extensions',
    'accounts-devices': 'Devices',
    'accounts-gateways': 'Gateways',
    'accounts-domains': 'Domains',
    'accounts-groups': 'Group Manager',
    'dialplan-destinations': 'Destinations',
    'dialplan-inbound': 'Inbound Routes',
    'dialplan-outbound': 'Outbound Routes',
    'dialplan-manager': 'Dialplan Manager',
    'dialplan-callflows': 'Call Flows',
    'dialplan-ivr': 'IVR Menus',
    'dialplan-ringgroups': 'Ring Groups',
    'dialplan-queues': 'Call Queues',
    'dialplan-timeconditions': 'Time Conditions',
    'dialplan-followme': 'Follow Me',
    'dialplan-forward': 'Call Forward',
    'dialplan-moh': 'Music On Hold',
    'dialplan-voicemail': 'Voicemail',
    'dialplan-emergency': 'Emergency Routes',
    'dialplan-translation': 'Number Translation',
    'callcenter-active': 'Active Calls',
    'callcenter-agents': 'Active Agents',
    'callcenter-monitor': 'Queues Monitor',
    'callcenter-status': 'Agent Status',
    'callcenter-broadcast': 'Call Broadcast',
    'callcenter-recordings': 'Call Recordings',
    'callcenter-cdr': 'Call Logs (CDR)',
    'callcenter-analytics': 'Call Analytics',
    'callcenter-realtime': 'Real-Time Monitor',
    'conferences-rooms': 'Conference Rooms',
    'conferences-profiles': 'Conference Profiles',
    'conferences-live': 'Live Conferences',
    'monitoring-calls': 'Active Calls Monitoring',
    'monitoring-stats': 'Call Statistics',
    'monitoring-devices': 'Device Logs',
    'monitoring-emergency': 'Emergency Logs',
    'monitoring-eventguard': 'Event Guard',
    'monitoring-health': 'System Health',
    'billing-rates': 'Rate Plans',
    'billing-costing': 'Call Costing',
    'billing-clients': 'Client Billing',
    'billing-invoices': 'Invoices',
    'billing-payments': 'Payments',
    'recordings-calls': 'Call Recordings',
    'recordings-voicemail': 'Voicemail Recordings',
    'system-sip': 'SIP Profiles',
    'system-access': 'Access Control',
    'system-settings': 'FreeSWITCH Settings',
    'system-api': 'API Manager',
    'system-logs': 'Logs Viewer',
    'system-backup': 'Backup & Restore'
};

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Handle submenu toggles
    const menuItems = document.querySelectorAll('.has-submenu > .nav-link');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });
    });

    // Handle navigation clicks
    const navLinks = document.querySelectorAll('[data-section]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const section = this.getAttribute('data-section');
            loadContent(section);
            
            // Update active state
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Close sidebar on mobile after selection
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('active');
            }
        });
    });

    // Load dashboard by default
    loadContent('dashboard');
});

// Function to load content
function loadContent(section) {
    const contentArea = document.getElementById('content');
    const pageTitle = document.getElementById('page-title');
    
    // Update page title
    pageTitle.textContent = pageTitles[section] || 'Dashboard';
    
    // Load content
    if (contentTemplates[section]) {
        contentArea.innerHTML = contentTemplates[section];
    } else {
        contentArea.innerHTML = `
            <div class="card">
                <div class="card-header">
                    <h2>${pageTitles[section] || 'Page'}</h2>
                </div>
                <div class="card-body">
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>Content for this section is under development.</p>
                    </div>
                </div>
            </div>
        `;
    }
}

// Handle hash changes for direct navigation
window.addEventListener('hashchange', function() {
    const hash = window.location.hash.slice(1);
    if (hash) {
        const link = document.querySelector(`[data-section="${hash}"]`);
        if (link) {
            link.click();
        }
    }
});

// Load content from hash on page load
if (window.location.hash) {
    const hash = window.location.hash.slice(1);
    const link = document.querySelector(`[data-section="${hash}"]`);
    if (link) {
        link.click();
    }
}
