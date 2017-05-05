The New-Western high school decided to implement a new, cloud-based administration software. The admission office would like to collect and store the most important data of the students in this new product. Additionally, they need to keep records of the study groups students are enrolled for.  
 
We would like to store these details of all students:

 * name 
 * sex 
 * place of birth 
 * date of birth 
 * email address 
 * study groups (maximum of 4 faculty per student) 
 
Properties of a study group:

 * name of the group
 * leader of the group (as string) 
 * subject (as string)
 * date and time of study group 
 * enrolled students 
  
Create an administration system, where the school can store all the mentioned data about student and study groups. During working on this, please pay attention to the following: 
 
 * John from the admission office asked for a paged, filterable list of students. (10 students per page as default, can search for student’s name, and select study groups with checkboxes) Plus, we need to show which study group a student enrolled for. 
 * Martha, his assistant has to do the following actions with students: 
 	+ Add new student 
 	+ Edit an existing student 
 	+ Delete a student (we need to delete all enrollments of the student also) 
 	+ Add a student to a study group. (Please pay attention to the school policy, which states that a student could attend the maximum of four study groups at a time.) 
 	+ Remove a student from a study group 
 	+ Every student has to be notified via email about every action with his/her profile. For example if a student is added to a group he/she has to receive and email about it. 
 * The guys in the office would like take a look on the software before it’s ready, so you do not have to create registration / loginw. 

Symfony Standard Edition 
========================

