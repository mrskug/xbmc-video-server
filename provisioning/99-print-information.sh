#!/bin/bash

IP_ADDR=`ifconfig | grep "inet addr" | grep -v "127.0.0.1\|10.0.2.\|172.17." | awk '{print $2}' | cut -d ":" -f2`

echo "XBMC Video Server is now available at: http://$IP_ADDR/"
