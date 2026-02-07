#!/bin/bash

##############################################################################
# FreeSWITCH Service Management Script
##############################################################################

case "$1" in
    start)
        echo "Starting FreeSWITCH..."
        sudo systemctl start freeswitch
        ;;
    stop)
        echo "Stopping FreeSWITCH..."
        sudo systemctl stop freeswitch
        ;;
    restart)
        echo "Restarting FreeSWITCH..."
        sudo systemctl restart freeswitch
        ;;
    status)
        sudo systemctl status freeswitch
        ;;
    reload)
        echo "Reloading FreeSWITCH configuration..."
        fs_cli -x "reloadxml"
        ;;
    cli)
        echo "Connecting to FreeSWITCH CLI..."
        fs_cli
        ;;
    logs)
        echo "Tailing FreeSWITCH logs..."
        tail -f /var/log/freeswitch/freeswitch.log
        ;;
    channels)
        echo "Showing active channels..."
        fs_cli -x "show channels"
        ;;
    registrations)
        echo "Showing registrations..."
        fs_cli -x "show registrations"
        ;;
    calls)
        echo "Showing calls..."
        fs_cli -x "show calls"
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|status|reload|cli|logs|channels|registrations|calls}"
        exit 1
        ;;
esac
