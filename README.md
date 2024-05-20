# Student Marketplace
This repository is for DITU3934 SYSTEM DEVELOPMENT WORKSHOP project.

# Team Members 
- AQEM ZAKWAN BIN AHMAD D032210409
- KHOO ZHEN XIAN D032210367
- AHMAD AFIQ BIN ABD JALIL D032210027
- ADAM HAZRIQ BIN MOHD JAFRI D032210208

# Get Started
## Software Requirement
1. [XAMPP CONTROL PANEL](https://www.apachefriends.org/download.html)
2. [Composer](https://getcomposer.org/Composer-Setup.exe)
3. [Git](https://git-scm.com/download/win)

**Note:** For composer setup, you can choose your php.exe in your xampp directory, you also can tick the checkbox to add PHP in your system enviroment.
For example: My xampp directory is under C:\xampp
![image](https://github.com/khoo04/Student-Marketplace/assets/50954737/7abd5385-032d-447e-8547-877eb350681d)

## Install project
Open a terminal(cmd) in the htdocs folder. htdocs is where all of your local projects go. (In somecase, your commmand prompt may require system adminsitor premissions)
htdocs folder location:
Windows - C:\xampp\htdocs (by default)

Or you can run this command 
```cmd
cd C:\xampp\htdocs
```

### Clone This Repos
```cmd
git clone https://github.com/khoo04/Student-Marketplace.git
```

### Install all dependencies (Make sure you have installed composer in your machine)
```cmd
composer install
```

### Copy the .env.example and configure it to suitable your development environment
```cmd
cp .env.example .env
```

## Virtual Host Setup
### Edit Hosts File
1. Go to location: C:/Windows/System32/drivers/etc
2. Find the "hosts" file, open with notepad or text editor with system adminsitor premission 
3. Add this line
```
127.0.0.1	marketplace.test
```
### Edit Virtual Hosts File
1. Go to location: C:/xampp/apache/conf/extra/
2. Find the "httpd-vhosts.conf" file, open with notepad
3. Add this line
```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/student-marketplace/public"
    ServerName marketplace.test
 </VirtualHost>
```

## All Set
You may start your web application now with xampp control panel
![image](https://github.com/khoo04/Student-Marketplace/assets/50954737/318e7dab-26a3-4efb-8d51-d5f1fca61ebb)

Open your browser, go to 'http://marketplace.test/' , you may see the default page of laravel.
