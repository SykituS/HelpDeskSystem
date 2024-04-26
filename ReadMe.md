# Project Title

The "Help Desk" project is designed to facilitate communication between users and people from departments responsible for support in case of breakdowns or other issues. The application not only facilitates contact and conversations with the right people but also allows us to keep and review the history of requests we have submitted, participated in, or assigned to ourselves.

## System Requirements

- Apache version: Apache/2.4.38 (Debian)
- PHP version: 8.1.17
- MySQL version: 8.0.33

## Installation

After uploading the site to the server, navigate to the URL where the site should be located. This should automatically start the site installer. If the installer does not start, ensure that the "Install.php" file is in the same location as index.php. Then manually start the installer by entering the URL _/Install.php, where _ is the base URL of our site.

Before beginning the installation process, ensure a MySQL database has been created to store information about the HelpDesk system.

### Installation Process:

The installer consists of 7 steps:

1. **Start of Installation**: This step checks if the Config.php file exists. If it does not, it's required to create it. If the file exists, its permissions are checked, and it must be readable and writable. If these conditions are met, the installer moves to step 2.
2. **Database Configuration Form**: Here, you'll need to provide the name of the previously created database, the server where it is hosted, the database user's login and password, and the ability to create tables, add, and modify data. You can also add a table prefix for the database.
3. **Database Tables Import**: At this stage, the database tables are imported, and the user doesn't have to do anything.
4. **Application Configuration Form**: You'll need to provide details like the application name, the base domain address for the app, creation date, version, company name, company address, and phone number.
   Additional fields in this form require creating an administrator account by providing the administrator's name, department, email address, and setting and confirming the password.
5. **Application Configuration Storage**: Here, data on application configuration is saved to Config.php. The user doesn't have to do anything.
6. **Creation of New Records**: At this step, records are created in the database for the department where the administrator works, and the administrator's account is created. The user doesn't have to do anything.
7. **End of Installer**: At this stage, it's possible to delete files related to the installer, such as Install.php and the InstallationResources folder in the Configuration folder.

## Authors

#### **Mateusz Jaruga**

#### **Mateusz Kalenik**

## External Libraries Used

- Bootstrap 5.2.3
- jQuery 3.6.0
- Feather Icons
- Flatpickr -> Date Picker
