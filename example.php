<?php
/*
   PhP virtualization API for KVM
   Developed by Erik Stütz in heart of Europe
   Github: https://github.com/stutzerik
   Licensed under the GNU General Public License v3.0
*/

use Virtualization;

//Require class file
require "virtulization.class.php";

//call the class
$libvirt = new KVM();

//create new VM 
//VM details 
$name = "ubuntu_server22";
$ostype = "Linux";
$vcpus = 1;
$memory = 1024;
$disk_size = 20;
$cdrom = "/iso/ubuntu_server_22.04.iso";

//Run deploy command
$libvirt->createVM($name, $ostype, $vcpus, $memory, $disk_size, $cdrom);

//For example, restart the VM
$libvirt->rebootVM($name);

//For example, page visitor/user start VM, when click to the button
if(isset($_POST['btn-start']))
{
   $libvirt->stopVM($name);
}

//It's easy to manage VMs via PhP, HTML & Bash

?>
<html>
   <body>
      <form method="POST">
         <button type="submit" name="btn-start">Start VM</button>
      </form>
   </body>
</html>