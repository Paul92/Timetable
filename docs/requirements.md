
Contest Brief

I need a timetable generator for schools. I just need the algorithm, it mean that the conection with database is not necessary. In fact, the script can start with an static teachers, students, courses and subjects, so it's not neccessary develop the insert in these arrays. Specifications:

- The script MUST to be written in PHP 5.3+.
- Timetable need courses, teachers and subjects. The relationship between them are:
+ One subject can have many teachers and one teacher can have many subjects. For example: teacher A can teach English and Maths and English can be teached by teacher A and teacher B.
+ One course has many subjects and one subject has just one course.
+ One subject has many students and one student has many subjects.


- Restrictions to make the timetable:
+ You have to be able choose the schedule of everyday. For example: Monday to Friday - 8.00AM to 15.00.PM but Wednesday just from 8.00 AM to 13.00 PM
+ You have to be able choose how many hours per week has each subject and the minimum and maximum hours per day. Moreover, you can choose if you want that hours must be correlative or not. For example: English has 10 hours per week group by 2 or 3 hours every day. So one day English will not have even 1 or 4 hours. Moreover, if you have choosen "correlative hours" and English has 2 hours if it start at 10.00 AM, will finish at 12.00 AM.
+ The hours can't overlap between teachers, students, subjects or courses. For example: if one teacher has a subject in the Course A from 8.00AM to 10AM, he mustn't has another subject in any other course at the same time.
+ Subjects should be as separated as can. For example: if one solution is English on Monday and Tuesday and another English on Monday and Thursday, the second option has priority.
+ Subjects can be fix in the schedule, if you want. For example: You can choose that English must be Monday and Tuesday from 8.00 to 10.00 but the rest can be variable.
+ A timetable of course MUSTN'T HAVE any blank slot. Subjects start at the first hour and finish the last hour without any blank.
+ A timetable of teacher SHOULDN'T HAVE any blank slot (if it's possible).
+ You can choose if teachers prefer the first hours, middle hours or last hours for the journey (respect to the schedule preconfigured before). For example: if teacher A prefer "First hours" and there are two results than one day his journey go from 8.00 to 10.00 and another from 13.00 to 15.00 the first one has priority.
+ You have to be able to group subjects to have the same schedule. For example: if there are two optatives in one course, these optatives used to have the same schedule, so you must to choose it.

-Extras:
+ Well documented script
+ Export to image and HTML the choosen solution
+ Show the 10 best solutions
+ Oriented Object programming