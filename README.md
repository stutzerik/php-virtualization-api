# Minimal PhP class for manage KVM machines
PhP virtualization class for manage KVM machines. You can easily manage virtual machines from a PhP-based web interface, all you need is to call this class and have minimal PhP knowledge.

## Install & usage
1. Call the the class file
```
require "virtualization.class.php";
```

2. Declare an instance
```
$libvirt = new KVM();
```

3. Declare variables of the VM
```
$name = "ubuntu_server22"; 
//Operating system type - "Linux"/"Unix"/"Windows"/"Solaris"
$ostype = "Linux"; 
//Number of vCPU cores
$vcpus = 1;
//Memory in MB 
$memory = 1024; 
//Disk size in GB
$disk_size = 20; 
//ISO file path
$cdrom = "/iso/ubuntu_server_22.04.iso"; 
```


4. Deploy new machine
```
$libvirt->createVM($name, $ostype, $vcpus, $memory, $disk_size, $cdrom);
```
...or call other functions:

```
$libvirt->start($name);
$libvirt->stopVM($name);
$libvirt->rebootVM($name);
$libvirt->suspendVM($name);
```

Important: Virtual machines are identified and managed by name.

## Basic usage
```
$libvirt-><function name>(<virtual machine name>);
```

## Linux System requirements

1. Apache2 & PhP 7/8
2. Libvirt & QEMU-KVM installed 
3. Permission for Apache/HTTPD to run commands as sudo user (/etc/sudoers)

## License
GNU General Public License v3.0
