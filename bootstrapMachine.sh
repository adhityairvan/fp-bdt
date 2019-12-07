# Referensi:
# https://pingcap.com/docs/stable/how-to/deploy/from-tarball/testing-environment/

# Update the repositories

# Downloads the package.
cp /vagrant/installer/prometheus-2.2.1.linux-amd64.tar.gz .
cp /vagrant/installer/node_exporter-0.15.2.linux-amd64.tar.gz .
cp /vagrant/installer/grafana-4.6.3.linux-x64.tar.gz .

# Extracts the package.
tar -xzf prometheus-2.2.1.linux-amd64.tar.gz
tar -xzf node_exporter-0.15.2.linux-amd64.tar.gz
tar -xzf grafana-4.6.3.linux-x64.tar.gz


# Install nano text editor
sudo yum -y install nano wget unzip

sudo yum -y install httpd
sudo systemctl start httpd.service
sudo systemctl enable httpd.service

sudo yum -y install yum-utils
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum-config-manager --enable remi-php73
sudo yum -y install php php-opcache php-pdo php-mysql php-xml php-gd php-opcache php-mbstring

#install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

#disable selinux 
sudo setenforce 0
sudo systemctl stop firewalld
sudo systemctl disable firewalld