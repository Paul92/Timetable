layout.php

This is the basic page layout for generating the timetable. It should
include an area for the timetable itself and some space for forms maybe.

index.php

This is the core of the application. It should coordinate entire data flow and
execution flow, calling other functions included.

functions.php

Here are all the functions required by the application. Of course, this is a 
temporary solution because as the application grows in size and complexity, 
there are needed more files to hold all the functions, and this file would
include the other files (to preserve backward compatibility). 


The basic modules are:

- input

  Deals with input checking and error detection and updating database

- database

  In early stages of development, it may be simulated (not a real database)

- timetable generator

  It is the actual algorithm that fetches the database and generates a timetable
  based on it


The development should start with a basic database module. This should be
as simple as possible, because it should be replace with an actual database, 
but it's interface should be as similar with an actual database as posible
to make the switch smooth.
I think the best way to implement it is a text file and a parser that fetches
the file and generates an normalized data structure, which is passed over.
That structure can also be generated from an actual database, so it should
be simple to replace.

This file should have a very well-defined geometry. My idea is the following 
format:

Schedule

Monday: 12:30-14:30
Tuesday: ...
...
Friday: 10:00-15:00

Courses:

Course1: courseName1 teacherName1
subject1
subject2
...
subjectn

Course2: courseName2 teacherName2
subject1
...


For v0.1 we shouldn't bother with multiple teachers/subject or multiple
subjects/teacher so this should be fine for now. Also, it's pretty simple
to parse.

After building this database, the next step is to build the layout. Because
i think it's too early to build the entire layout, i guess it would be enough
to build just a form to implement feature1 (to allow user to choose a schedule).

Total investment until now: 2.5 mh
