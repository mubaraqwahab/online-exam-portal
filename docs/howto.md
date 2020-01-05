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
  - [Database Structure (Approximate)](#database-structure-approximate)
    - [Tables](#tables)
    - [Expiring Token](#expiring-token)


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


Database Structure (Approximate)
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



### Expiring Token
* When your user requests a password reset, generate a token and calculate its expiry date
* Store the token and its expiry date in separate columns in your users table for that user
* Send an email to the user containing the reset link, with the token appended to its URL
* When your user follows the link, grab the token from your URL (perhaps with `$_GET['token']`)
* Verify the token against your users table
* Check that it's not past its expiry date yet
* If it has expired, invalidate it, perhaps by clearing the fields, and allow the user to resend
* If the token is valid and usable, present your password reset form to the user
* Validate and update the password and clear the token and expiry fields
