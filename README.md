# PhP class for manage KVM machines
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
$name = "ubuntu_server22"; //Name of VM
$ostype = "Linux"; //Operating system type - "Linux"/"Unix"/"Windows"/"Solaris"
$vcpus = 1; //Number of vCPU cores
$memory = 1024; //Memory in MB
$disk_size = 20; //Disk size in GB
$cdrom = "/iso/ubuntu_server_22.04.iso"; //ISO file path
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
