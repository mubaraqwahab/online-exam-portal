How to: Online Exam Portal
===

Contents
---
* [Outline](#outline)
* [Naming Convention](#naming-convention)
* [Database Structure](#database-structure)

Outline
---

### Sign up
* Name
* Student Reg No (optional)
* Level (optional)
* Passport photo
* Email
* Username
* Password

### Sign in
* Username
* Password

#### Password Forgotten??
* Ask for email address
* If it exists in database, send a email to the address containing a link to reset the password.
* The link should have an expiry time.

### Dashboard
* My Quizzes
* Exams
* Create Exam
* Update Profile
* Sign out

### My Quizzes (for lecturer*)
* See all your created quizzes here.
* You can:
  * edit or delete.
  * assign to students using username or email.
  * list students with their info (name, id, level, dept, score) for each quiz
  * grade students and return grades.
  * generate excel sheet for all students.*
  * print grade list of all students.*

### Exams (for student*)
* See all quizzes assigned to you.
* Take quizzes and get results. (Immediate results for multi-choice)
* Accept/reject invitation to take quiz.

### Create Exam (for lecturer*)
* Create an exam
* Choose no of questions
* Choose type of questions (multi-choice, theory or fill in the blank)
* All quizes must have a unique auto-generated code.
* You can share the code to students or assign the quiz to them using their username or email.

#### Multi-choice questions
* Give questions and answers.

### Update Profile
* Update any profile details besides the username.

Naming Convention
---

### HTML/CSS
* Class name -> `class-name`
* ID -> `elementId`

### JavaScript
* Variable -> `myVariable`
* Constant -> `MY_CONSTANT`
* Function -> `doSomething()`

### PHP
* Variable -> `$myVariable`
* Constant -> `MY_CONSTANT`
* Function -> `doSomething()`
* Class -> `MyClass`
* Keyword -> `true`

### SQL/DB
* Command/keyword -> `SELECT`
* Field name -> `Username`, `RegNo`
* Use singular names for tables, fields, etc. -> `Exam` table (not `Exams`), `Email`

Database Structure
---

![Database structure](doc-images/db-structure.png)

### Sign Up
* Collect user details
* Rename uploaded picture to something like '[User ID]_pic.jpg'
* Insert the details into 'User Profile' table

### Sign In
* Collect user input
* Check it against records in 'User Profile' table
* If user ID doesn't exist, suggest signing up
* If password incorrect, suggest recovering it

## Recover Password
* Get email
* Validate email for that user ID
* (What to do next?)

### View Profile
* Select all fields (except password) for the User ID from 'User Profile' table
* Print data to screen.

### Update Profile
* Get new profile details (except user ID)
* Update the record for the user ID in 'User Profile' table.

### Create Exam
* Get exam details (course code, course name, exam title, type, no of questions)
* Get instructor ID from the current user's ID
* Insert the data into 'Exam' table
* For a multi-choice question:
  * Get each question, along with its mark and correct answer
  * That data goes into the 'Multi-choice Question' table.
  * Get the options for the question
  * Insert them into the 'Options Group' table.
* For a fill-in-the-blank/theory question:
  * Get each question, along with its mark
  * Insert the data into the 'Fill-in the Blank & Theory' table
* Get user IDs of assigned students
* Insert user IDs, and exam ID and status into 'Assignment' table. Status ID should point to 'Awaiting approval' initially.
* Return exam ID to user.

### Exams
* Select exam details of all exams assigned to (and not rejected by) current user. Print to screen.
* When user decides to take a multi-choice exam:
  * Set assignment status ID to indicate 'In progress'
  * Select all question details from the 'Multi-choice Question' table, where the exam ID belongs to the exam chosen by the user.
  * Print to screen
  * When user is done:
    * Get user's responses details (question id, assignment id, reponse) and insert into 'Question Response' table.
    * Set assignment status ID to indicate 'Turned in'
    * Check each response against the correct answer for the question
    * Set the score field for each response in 'Question Response'.
    * Sum all the scores to get the total.
    * Set the total score field of the 'Assignment' table to the calculated total
    * Set assignment status ID to indicate 'Graded'
    * Notify student
* When user decides to take other exams:
  * Set assignment status ID to indicate 'In progress'
  * Select all question details from the 'Fill-in ... Question' table, where the exam ID belongs to the exam chosen by the user.
  * Print to screen
  * When user is done:
    * Get user's responses details (question id, assignment id, reponse) and insert into 'Question Response' table.
    * Set assignment status ID to indicate 'Turned in'
    * Notify instructor to grade exam
    * Set the score field for each response in 'Question Response' table to the score given by the instructor.
    * Sum all the scores to get the total.
    * Set the total score field of the 'Assignment' table to the calculated total
    * Set assignment status ID to indicate 'Graded'
    * Notify student.
* When user accepts exam invitation, set assignment status ID to indicate 'Ready'.
* When user rejects exam invitation, set assignment status ID to indicate 'Rejected'.

## My Quizzes
* Select fields from the 'Exam' table where the instructor ID is the current users ID, and print to screen
* _(I'd leave the rest for now...)_