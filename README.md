## About Test Management System

This is a simple test management system to manage testing subjects and their test submissions.

### User Roles
- Admin
- Normal User (Testing Subjects)
- System Admin (Developer)

### User stories
1. Guests can register to become test subjects
2. Admins and users can login using username and password
3. Admins can view all user profiles
3. Admins can edit questions and options
4. Users can submit responses
5. Users can view their past submissions
6. System admin can run tests to make sure everything works

### Development Stack
This system is built on Laravel 8, Breeze and Sail

### Setup
-   Clone the source code
-   ./vendor/bin/sail up (make sure Docker is installed first)
-   ./vendor/bin/sail shell (to go to Sail's shell)
-   npm install && npm run dev
-   composer install (if required)
-   access via localhost (with port depending on your configuration)

### Progress
- Scaffolding of the system (welcome, register, login, logout, reset password) have been done.
- Backend API for all user cases above are completed with test coverages

### Things to be done
- Develop remaining front end pages
- Create questionnaire model to group questions
