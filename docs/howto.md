How to: Online Exam Portal
===

Contents
---
- [How to: Online Exam Portal](#how-to-online-exam-portal)
  - [Contents](#contents)
  - [Outline](#outline)
    - [Sign up](#sign-up)
    - [Sign in](#sign-in)
      - [Password Forgotten??](#password-forgotten)
    - [Dashboard](#dashboard)
    - [My Quizzes (for lecturer*)](#my-quizzes-for-lecturer)
    - [Exams (for student*)](#exams-for-student)
    - [Create Exam (for lecturer*)](#create-exam-for-lecturer)
      - [Multi-choice questions](#multi-choice-questions)
    - [Update Profile](#update-profile)
  - [Naming Convention](#naming-convention)
    - [File/Folder](#filefolder)
    - [HTML/CSS](#htmlcss)
    - [JavaScript](#javascript)
    - [PHP](#php)
    - [SQL/DB](#sqldb)
  - [Database Structure](#database-structure)
    - [Tables](#tables)
    - [Procedure](#procedure)
      - [Sign Up](#sign-up)
      - [Sign In](#sign-in)
      - [Recover Password](#recover-password)
      - [View Profile](#view-profile)
      - [Update Profile](#update-profile-1)
      - [Create Exam](#create-exam)
      - [Exams](#exams)
      - [My Quizzes](#my-quizzes)


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

### File/Folder
* Name -> `myfile.txt`, `my-file.txt`

### HTML/CSS
* Class name -> `class-name`
* ID -> `elementId`
* Form input name -> `inputName`

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
* Database, table & field/column name -> `my_database`, `exam`, `user_id`
* Use singular names for tables, fields, etc. -> `response` table (not `responses`), `email` field (not `emails`)

Database Structure
---

![Database structure](images/db-structure.jfif)

### Tables

1. **User Profile** stores user profile data

2. **Exam** stores exam info (not including the questions)

3. **Assignment** stores exam assignment info (i.e. which exam has been assigned to which user), and the user's score in the exam, and status of the assignment (whether the user has started it, completed it, etc.).

4. **Multi-choice Question** stores info about multi-choice questions, like the exam to which a question belongs, the question number, mark, correct answer, the options and the question itself.

5. **Fill-in the blank & Theory Question** stores info about the other two question types.

6. **Question Response** stores data about the user's responses to questions. So it holds the responses, the scores of the responses, and the question and asignment IDs to which the response belongs.

7. **Level** is a lookup table to store the different possible levels. It's like an 'enum' in programming languages.

8. **Exam Type** is a lookup table to store the types of exams.

9. **Status** is another lookup table. It stores exam assignment status.

### Procedure

#### Sign Up
* Collect user details
* Rename uploaded picture to something like '[User ID]_pic.jpg'
* Insert the details into 'User Profile' table

#### Sign In
* Collect user input
* Check it against records in 'User Profile' table
* If user ID doesn't exist, suggest signing up
* If password incorrect, suggest recovering it

#### Recover Password
* Get email
* Validate email for that user ID
* (What to do next?)

#### View Profile
* Select all fields (except password) for the User ID from 'User Profile' table
* Print data to screen.

#### Update Profile
* Get new profile details (except user ID)
* Update the record for the user ID in 'User Profile' table.

#### Create Exam
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

#### Exams
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

#### My Quizzes
* Select fields from the 'Exam' table where the instructor ID is the current users ID, and print to screen
* _(I'd leave the rest for now...)_

> **NB**: What happens when an exam is deleted?