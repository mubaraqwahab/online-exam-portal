# Queries

## Sign up
Insert
  * user id,
  * first name,
  * last name,
  * email
  * password
  * level id
  * profile picture
into 'user'

## Sign in
Find record where
  * user id input exists and
  * password input exists.

## Recover password
Select record where
  * email input exists

## Reset password
Update
  * password
where user id* exists
in 'user'

## View Profile
Select
  * user id
  * first name
  * last name
  * email
  * level id
  * profile picture
from 'user'

## Update Profile
Update (where necessary)
  * first name
  * last name
  * email
  * password
  * level id
  * profile picture
in 'user'

## Create Exam
Insert
  * instructor id
  * course code
  * title
  * type id
  * no of questions
into 'exam'

Get exam id

Insert
  * exam id
  * question no
  * question
  * (correct answer)
  * (a)
  * (b)
  * (c)
  * (d)
  * mark

> ALTER TABLE `exam_portal`.`user` DROP INDEX `password_UNIQUE`, ADD UNIQUE `email_UNIQUE` (`email`) USING BTREE