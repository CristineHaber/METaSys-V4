-------------------------------------------------------------------------------------------------------------------------------------
METASYS
November 2023
-------------------------------------------------------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------------------------------------------------------
1. Extrating the Zip File
-------------------------------------------------------------------------------------------------------------------------------------
To extract or unzip the zip file, you must have extracting application like Winrar or Breezip app. 
Step 1: Click the Zip File named metasys-v4.
Step 2: Right click the file then extract it with the application that you installed in your computer like Winrar or Breezip.
Step 3: Wait for a few minutes to extract the file, do not close the extracting progress while extracting.
Step 4: Once it is done, the zip file become a File Folder.

-------------------------------------------------------------------------------------------------------------------------------------
2. Installation of XAMPP:
-------------------------------------------------------------------------------------------------------------------------------------
If you haven't already, download and install XAMPP from the official website: https://www.apachefriends.org/index.html
Step 1: Follow the installation instructions provided for your operating system.
Step 2: Start the Apache and MySQL services from the XAMPP Control Panel.

-------------------------------------------------------------------------------------------------------------------------------------
3. Install Visual Studio Code:
-------------------------------------------------------------------------------------------------------------------------------------
If you haven't already, download and install Visual Studio Code from the official website: https://code.visualstudio.com/
Follow the installation instructions provided for your operating system.

Open the Project in Visual Studio Code:

Step 1:  Launch Visual Studio Code.
Step 2:  Go to File > Open Folder, and select the folder(metasys-v4) where you extracted the ZIP file containing your Laravel project.
Step 3:	 Run "composer install" to install the project dependencies specified in the composer.json file.
Step 4:  Rename the .env.example file to .env.
Step 5:  Generate a new application key by running php artisan key:generate.

Migrate and Seed the Database:

Step 6:  In the terminal, run "php artisan migrate" to execute outstanding migrations.
Step 7:  Run "php artisan db:seed" to populate the database with sample data.
-------------------------------------------------------------------------------------------------------------------------------------
3. Run the Application
-------------------------------------------------------------------------------------------------------------------------------------
Step 7:  In the terminal, navigate to the root folder of your metasys-v4 project.
Step 8:  Run "php artisan serve" to start the Laravel development server.
Step 9:  Click the localhost server address to view the metasys-v4 system.

-------------------------------------------------------------------------------------------------------------------------------------
5. SYSTEM REQUIREMENTS
-------------------------------------------------------------------------------------------------------------------------------------
- OS [64-bit operating system, x64-based processor]
- XAMPP for Windows 8.1.17

Admin Login
_______________________________
Username: Administrator
Password: 111





