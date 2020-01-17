## Step 1. Setting up the web server
1. Install XAMPP 5.5 from [here](https://www.apachefriends.org/download.html) or download from [here](https://aladdin-eax.inf.cs.cmu.edu/shares/software/xampp-linux-x64-5.5.34-0-installer.run).
2. Import the initial database (initial.sql) into new MySQL database called "LectureAttendanceApp"
3. Add localhost database user with username "lectureAttDBUser" and "mysqlpassword", or change webapp/protected/config/main.php with your username and password
4. Correct some folder permissions:
```
$ cd webapp; chmod -R 777 assets/; mkdir protected/runtime; chmod 777 protected/runtime
```
5. Move the webapp folder to the Apache Server document path.


## Step 2. Testing
1. Open a browser (we only tested Chrome) and log in as TA at: http://127.0.0.1/webapp/index.php/admin:
username: ta
password: 123456

2. After logging in, you should see there is already one entry in the lecture list (question form list). Click "Edit" of that entry or create your own. Then in the next page, change "expiredTime" to a future time, upload classroom image, enter some questions and answers. Then click "Save". Then click "NotReady" and then "Ready!" so that the server will cache these latest changes.

3. Then use the shoutkey (peaches) and visit as a student attending the lecture at http://127.0.0.1/webapp?k=peaches. Enter student ID (we call it "andrew ID") and name, answer the questions, click where you were sitting, and then click "Submit". Then at the TA site (the main page), click the eye icon and you should see how many submissions and where the students were sitting.

4. If you want to add more TA accounts, log in with account "admin"/"123456". Click "userManager" and then don't select "Super Manager"/"User Manager" and select "High-level User". Then enter the username and click "Add User".
