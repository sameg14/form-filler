Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.33.14"
  config.vm.synced_folder ".", "/var/www/poc"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end
end