<?php
/*
   PhP virtualization API for KVM
   Developed by Erik Stütz in heart of Europe
   Github: https://github.com/stutzerik
   Licensed under the GNU General Public License v3.0

*/

namespace Virtualization;

//KVM
//Declaration the class for KVM virtual machine management
//Installation of QEMU-KVM and Libvirt is required for proper operation
class KVM
{
    /** 
    * @var
    */

    public string $name; //Virtual machine name
    public string $ostype; //Operating system type - "Linux"/"Unix"/"Windows"/"Solaris"
    public int $vcpus; //Number of vCPU cores
    public int $memory; //Memory of virtual machine in MB
    public int $disk_size; //Hard drive disk size in GB
    public string $cdrom; //Operating system ISO file path or Linux repo URL (example: /tmp/iso/Windows_server_2022.iso). Important: Don't use spaces in URL
    public string $snapshot_name; //Name of the snapshot
    public string $local_server = $_SERVER['SERVER_ADDR']; //IP address of your KVM local server

    //Create virtual machine & enable autoboot
    //After the first start You can connect via VNC 
    public static function createVM($name, $ostype, $vcpus, $memory, $disk_size, $cdrom)
    {
        $cmd = "/usr/bin/sudo virt-install --connect=qemu:///system --virt-type kvm --name={$name} --os-type={$ostype} --vcpus={$vcpus} --memory={$memory} --disk size={$disk_size} --cdrom={$cdrom} --network network=default --graphics vnc, listen=0.0.0.0 --noautoconsole > /dev/null 2>&1
        /usr/bin/sudo virsh autostart {$name} > /dev/null 2>&1";

        //Run the command in local system
        return shell_exec($cmd);
    }

    //Clone virtual machine
    //Cloned machine name: <current-vm-name>-clone
    public static function cloneVM($name)
    {
        $cmd = "/usr/bin/sudo virt-clone --original={$name} --name={$name}-clone --file=/var/lib/libvirt/images/{$name}.qcow2 > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Remove virtual machine from the disk
    public static function removeVM($name)
    {
        $cmd = "/usr/bin/sudo virsh shutdown {$name} > /dev/null 2>&1
        /usr/bin/sudo virsh destroy --domain {$name} > /dev/null 2>&1
        /usr/bin/sudo virsh undefine --domain {$name} > /dev/null 2>&1
        /usr/bin/sudo rm -rf /var/lib/libvirt/images/{$name}.qcow2 > /dev/null 2>&1";
        return shell_exec($cmd);    
    }

    //Show VNC connection port 
    public static function showVNC($name, $local_server)
    {
        $cmd = "/usr/bin/sudo vncdisplay {$name}";
        $vncport = shell_exec($cmd);


        //The default VNC address is: 
        //Your KVM server IP:5901
        return echo "VNC server IP: {$local_server}:{$vncport}";
    }

    //Start virtual machine 
    public static function startVM($name)
    {
        $cmd = "/usr/bin/sudo virsh start {$name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Stop virtual machine
    public static function stopVM($name)
    {
        $cmd = "/usr/bin/sudo virsh shutdown {$name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Restart virtual machine
    public static function rebootVM($name)
    {
        $cmd = "/usr/bin/sudo virsh reboot {$name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Suspend virtual machine
    public static function suspendVM($name)
    {
        $cmd = "/usr/bin/sudo virsh suspend {$name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Resume virtual machine
    public static function resumeVM($name)
    {
        $cmd = "/usr/bin/sudo virsh resume {$name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Create backup from virtual machine's disk file
    public static function snapshotVM($name, $snapshot_name)
    {
        $cmd = "/usr/bin/sudo virsh snapshot-create-as --domain {$name} --name {$snapshot_name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Delete backup
    public static function delete_snapshot($name, $snapshot_name)
    {
        $cmd = "/usr/bin/sudo virsh snapshot-delete --domain {$name} --snapshotname {$snapshot_name} > /dev/null 2>&1";
        return shell_exec($cmd);
    }

    //Restore VM's backup
    //We need shutdown VM, before backing up
    public static function restoreVM($name, $snapshot_name)
    {
        $cmd = "/usr/bin/sudo virsh shutdown --domain {$name} > /dev/null 2>&1
        /usr/bin/sudo virsh snapshot-revert --domain {$name} --snapshotname {$snapshot_name} --running > /dev/null 2>&1";
        return shell_exec($cmd);
    }
}

?>