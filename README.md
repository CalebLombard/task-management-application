📅 CSK Task Management Application 📅

Project Description:

This application helps you and your team stay organized without the hassle. This application allows you to create, edit, and assign tasks easily, set priorities and categories, and keep track of progress with simple status updates. Additionally, never miss a deadline thanks to the email reminders. With roles like Admin, Team Member, and Guest, everyone knows their part and can jump in when needed.


🚀 Technologies & Frameworks Used:

Frontend: Tailwind CSS\
Backend: Laravel 12\
Database: mySQL\
Authentication: Laravel Breeze\
Email Notifications: Laravel's built-in notification system\
Development Tools: Composer


🛠️ Setup & Installation

Prerequisites:

Node.js\
Npm\
phpMyAdmin\
WampServer\
php


Installation:

1) Clone the repository\
git clone https://github.com/CalebLombard/task-management-application.git \
cd task-management-application

2) Install dependencies\
composer install\
npm install


3) Setup environment variables\
cp .env.example .env

4) Then edit .env with THIS config\
DB_CONNECTION=mysql \
DB_HOST=127.0.0.1 \
DB_PORT=3306 \
DB_DATABASE=task_management \
DB_USERNAME=root \
DB_PASSWORD= 

5) Start the development server\
npm run dev \
php artisan serve 


How To Setup Email Reminder Notification:

1) Create a Mailtrap account \
Go to mailtrap.io and sign up for a free account 

2) Get SMTP credentials: \
Open your Mailtrap inbox. \
Click SANDBOX > MY SANDBOX> SMTP Settings > PHP > Choose Laravel 9+ \
Copy your USERNAME and PASSWORD 

3) Setup environment variables: \
Open .env and replace the following lines with your Mailtrap credentials: \
MAIL_MAILER=smtp \
MAIL_HOST=sandbox.smtp.mailtrap.io \
MAIL_PORT=587 \
MAIL_USERNAME=your_mailtrap_username (e.g: 7c6ff1732eddd9) \
MAIL_PASSWORD=your_mailtrap_password  (e.g: 2cf26a9e5e2f63) \
MAIL_ENCRYPTION=tls \
MAIL_FROM_ADDRESS="tasks@example.com" \
MAIL_FROM_NAME="Task Management" \
QUEUE_CONNECTION=database 

4) In your terminal, clear config cache to apply changes: \
php artisan config:clear \
php artisan cache:clear 

5) Test sending notification emails: 

In your terminal, you can use Tinker with this command: \
php artisan tinker 

6) Inside Tinker, run: \
use App\Models\CSKtask; \
use App\Notifications\TaskDeadlineReminder; \
use Illuminate\Support\Facades\Notification; \
use Carbon\Carbon; 

$task = CSKtask::with('user')->first(); 

$daysRemaining = (int) floor(Carbon::parse($task->deadline)->diffInDays(now(), false)); 

Notification::route('mail', $task->user->email)->notifyNow(new TaskDeadlineReminder($task, $daysRemaining)); 

📘 Usage Guide: 

User Registration & Login: 

Register new account: /register \
Login: /login \
Login Credentials:  

Test User Login: test@example.com (password: testuser123) \
Guest User Login: guest@example (password: guestuser123) \
Admin User Login: admin@example.com (password: adminuser123) 
 
Creating a new task: 

After logging in, navigate to /tasks to create a new task. \
Tasks are displayed on the /tasks page. 

Editing a task: 
 
Click "Edit" to modify the task details (example: title, description, status) /tasks/create \
To save changes click the “Update Task” button 

View Completed Tasks: 

To check recently completed tasks, navigate to /completed \
🧠 Code Structure & Documentation 

The project includes inline comments and JavaScript-style docstrings to explain: 

Key functions \
API endpoints \
Component structure 

Example: 

<!-- Page Heading -->  

            @isset($header) 
                <header class="bg-[#18191a] shadow"> 
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
                        {{ $header }} 
                    </div> 
                </header> 
            @endisset 
