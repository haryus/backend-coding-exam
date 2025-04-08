Laravel Project Documentation: How to Copy, Install, and Run a Laravel Project
Prerequisites
Before you begin, ensure that you have the following installed on your machine:

PHP: Laravel requires PHP 7.4 or higher.

Composer: Laravel uses Composer for dependency management. Install Composer from https://getcomposer.org/.

Database: Laravel supports MySQL, PostgreSQL, SQLite, and SQL Server. Ensure you have one of these databases installed.

Node.js and NPM: For front-end build tools like Laravel Mix, you will need Node.js and NPM installed. Get them from https://nodejs.org/.

Step 1: Copy the Laravel Project
If you are working with an existing Laravel project, the first step is to copy the project files to your local machine. You can do this via Git or by downloading the project as a ZIP file.

Option 1: Clone the Repository (if using Git)
If the project is in a Git repository, clone the project using the following command:

bash
Copy
Edit
git clone https://github.com/haryus/backend-coding-exam.git
Option 2: Download as ZIP
If you have a ZIP file of the project, simply extract the contents to a directory on your local machine.

Step 2: Install Project Dependencies
Navigate to the project folder in your terminal or command prompt:

bash
Copy
Edit
cd your-laravel-project
Install Composer Dependencies
Laravel uses Composer to manage its PHP dependencies. To install the required dependencies, run:

bash
Copy
Edit
composer install
This will install all necessary PHP packages defined in the composer.json file.

Install Node.js Dependencies
Laravel often uses front-end assets compiled with Laravel Mix, which requires Node.js and NPM. To install the front-end dependencies, run:

bash
Copy
Edit
npm install
This will install the required JavaScript and CSS dependencies defined in the package.json file.

Step 3: Set Up Environment Variables
Laravel uses an .env file to manage environment settings such as database credentials, mail server configuration, and other sensitive information. You need to create this file if it doesn't already exist.

Copy the .env.example file to .env:

bash
Copy
Edit
cp .env.example .env
Generate an Application Key: Laravel requires an application key, which is a random string used to secure user sessions and other encrypted data. To generate the key, run:

bash
Copy
Edit
php artisan key:generate
Configure Environment Variables: Open the .env file and update the database and other settings as needed. Here’s an example of the database section:

env
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
Replace your_database, your_username, and your_password with your actual database credentials.

Step 4: Set Up the Database
Laravel uses migrations to manage database schema changes. After configuring the .env file, you need to run the database migrations.

Create the Database (if not already created):

Create the database manually in your MySQL/PostgreSQL/SQLite database or use a tool like phpMyAdmin or Sequel Pro.

Run Migrations:

Once the database is set up, run the following command to apply the migrations and create the necessary tables:

bash
Copy
Edit
php artisan migrate
This will create the tables defined in the migration files located in database/migrations.

Seed the Database (Optional):

If you want to populate the database with sample data, you can run the seeder:

bash
Copy
Edit
php artisan db:seed
Step 5: Run the Application
Now that the dependencies are installed, and the database is set up, you can start the Laravel development server.

Run the following command:

bash
Copy
Edit
php artisan serve
This will start the Laravel development server at http://localhost:8000.

You can now visit this URL in your web browser to access the Laravel application.

