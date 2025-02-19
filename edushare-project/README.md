# edushare-project

## Overview
The EduShare project is a web application designed for managing user accounts and tracking user activities. It allows users to sign up and log in, while also providing a mechanism to record their activities in a personalized manner.

## Project Structure
```
edushare-project
├── src
│   ├── db_connection.php
│   ├── signup.php
│   └── user_activities
│       └── [username].php
├── index.php
└── README.md
```

## Files Description

- **src/db_connection.php**: 
  - Establishes a connection to the MySQL database named "edushare".
  - Utilizes PDO for secure database interactions.
  - Handles connection errors gracefully.

- **src/signup.php**: 
  - Contains the logic for user sign-up.
  - Processes form data and validates input.
  - Inserts new users into the "accounts" table.
  - Creates a new table named after the username for logging user activities upon successful sign-up.

- **src/user_activities/[username].php**: 
  - Dynamically created based on the username during sign-up.
  - Handles user activity logging, allowing for the insertion of records into the user's specific activity table.

- **index.php**: 
  - Serves as the entry point for the application.
  - Includes links to the sign-up page and other functionalities.

## Setup Instructions

1. **Database Setup**:
   - Create a MySQL database named `edushare`.
   - Create a table named `accounts` with the following fields:
     - firstname
     - lastname
     - middle_name
     - suffix
     - username
     - password
     - email
     - phone_number
     - school
     - status (for students or professors)

2. **Configuration**:
   - Ensure that the database connection details in `src/db_connection.php` are correctly set to match your database credentials.

3. **Running the Application**:
   - Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Access the application via your web browser at `http://localhost/edushare-project/index.php`.

## Usage
- Navigate to the sign-up page to create a new account.
- Upon successful registration, a new table will be created for the user to log their activities.
- Users can log in to access their personalized activity logging page.

## Contributing
Contributions to the EduShare project are welcome. Please fork the repository and submit a pull request for any enhancements or bug fixes.