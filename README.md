# EazyWebQuiz
A simple website to create and test you're knowage (No Question DB)

## Prerequisites

Before you get started, make sure you have the following installed:

- PHP (version 5.6 or greater)
- MySQL Server (version 5.7 or greater)
- Web server (e.g., Apache, Nginx)
- Git (optional, for cloning the repository)

## Installation

1. Clone the repository (or download the ZIP file and extract it):
- git clone https://github.com/eXPeRi91/EazyWebQuiz.git

2. Import the SQL Database:
- Create a new database named web_quiz in your MySQL server.
- Import the database structure and data using the SQL script located in the sql directory.

3. Configure Database Connection:
- Open db_config.php.
- Update the database credentials with your MySQL server details.

4. Start the Web Server:
- Start your web server (e.g., Apache, Nginx).
- Ensure that PHP is properly configured and enabled.

5. Access the Website:
- Open a web browser and navigate to the hosted URL of the website.
- You should see the AvioTests website's homepage.

## Contributing
- Me @eXPeRi91

## License

- This project is licensed under the MIT License - see the LICENSE file for details.

## Usage

-    Home Page (index.php): View a welcome message and links to various sections of the website.
-    Quiz Page (quiz.php): Take a quiz by answering questions with multiple-choice options.
-    Add Question Page (add_question.php): Add new quiz questions to the database.
-    Add Category Page (add_category.php): Add new quiz categories to the database.
-    Quiz Results Page (quiz_result.php): See the results of the quiz you've taken.