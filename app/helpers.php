<?php

// function getMacAddress()
// {
//     $macAddress = 'N/A';
    
//     if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
//         $macAddress = exec('getmac');
//     } elseif (strtoupper(substr(PHP_OS, 0, 3)) === 'DAR') {
//         $macAddress = exec('ifconfig en0 | grep ether | awk \'{print $2}\'');
//     } else {
//         $macAddress = exec('cat /sys/class/net/eth0/address');
//     }
    
//     return $macAddress;
// }