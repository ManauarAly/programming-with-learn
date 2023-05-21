cd Downloads/   --> change the directory
chmod 400 WebServerKey.pem  --> change file permission
ssh ubuntu@204.249.162 -i WebServerKey.pem --> connect the instance
sudo apt update -y  --> update machine
sudo apt upgrade -y --> upgrade machine
sudo apt install apache2 -y --> install apache2 stream_socket_server
sudo systemctl status apache2 --> check the apache2 server status
sudo systemctl start apache2 --> start apache2 server
sudo systemctl enable apache2 --> enable apache service 
 
db-
sudo apt install mariadb-server mariadb-client  --> install db 
sudo systemctl start mariadb --> start the db service 
sudo systemctl status mariadb --> check the status db 
sudo mysql_secure_installation --> install mysql 
sudo systemctl restart mariadb --> restart mariadb db 
sudo apt install php php-mysql php-gd php-cli php-common 

wp- open wp download site right click and copy it.
sudo apt install wget unzip -y --> install unzip package 
sudo wget https://wordpress.org/latest.zip --> install wp
ls --> list status 
sudo unzip latest.zip --> unzip the file 
cd wordpress --> go to wp directory 
cd .. -->change directory 
sudo cp -r wordpress/* /var/www/html/ --> copy root directory file 
cd /var/www/html/ --> go to html directory 
ls --> list status 
cd 
ls -l --> check the ownership file 
sudo chown ww-data:ww-data -R /var/www/html/ --> permission 
ls -l --> 
cd /var/www/html/ --> go to this directory 
ls -- ls 
pwd /var/www/html
sudo rm -rf index.html --> remove this file 
ls -l 


create db-
sudo mysql -u root -p 
by default - root 
create database wordpress;
create user "admin"@"%" identified by "passadmin";
grant all privileges on wordpress.* to "admin"@"%";
