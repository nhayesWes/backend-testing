# Boomtree Database (music-db)
This markdown file contains the SQL queries for the music-db within Problem 1a on Homework 2 of Professor Sebastian Zimmeck's
Software Engineering course.

Created by Nigel Hayes '23 (nchayes@wesleyan.edu)

## 1. Setting up the music-db Database

- Using the XAMPP Control Panel, start your local server by clicking on
the "Apache" and "MySQL" Start buttons under -Actions-. (Should be the leftmost action button).

- Next, proceed to http://localhost:8080/phpmyadmin/. Click on 'Databases' along the top navigation bar.

- Under the title text for the databases page, there should be a window to 'Create Database'.
Type in "music-db" and use the default 'utf8mb4_general_ci' from the next dropdown.
Then, click "Create"!

- Congratulations, the music-db database is nearly done. Follow step 2 below to use the SQL queries and input the tables!


## 2. Adding the tables using SQL Queries

The following code below is designed for you to insert into the SQL tab from the music-db navigation bar.
You can insert the tables in sections if you'd like -OR- you can simply paste it all together and hit GO (bottom right).

REMEMBER: You MUST remove the dashed sql marks at the start and end of the following code section.

### Tables & Information SQL Query
```sql
CREATE TABLE users_table (username varchar(255), 
    password varchar(255), 
    PRIMARY KEY (username))

ENGINE = InnoDB;

CREATE TABLE artists_table (song varchar(255),
    artist varchar(255),
    PRIMARY KEY (song))
ENGINE = InnoDB;

CREATE TABLE ratings_table (id int(1) AUTO_INCREMENT,
    username varchar(255),
    song varchar(255),
    rating int(1),
    PRIMARY KEY (id, username, song),


    FOREIGN KEY (username)
      REFERENCES users_table(username)
      ON DELETE CASCADE,

    FOREIGN KEY (song)
      REFERENCES artists_table(song)
      ON DELETE CASCADE)
ENGINE = InnoDB;


INSERT INTO users_table(username, password) VALUES ("Amelia-Earhart", "Youaom139&yu7");
INSERT INTO users_table(username, password) VALUES ("Otto", "StarWars2*");

INSERT INTO artists_table(song, artist) VALUES ("Freeway", "Aimee Mann");
INSERT INTO artists_table(song, artist) VALUES ("Days of Wine and Roses", "Bill Evans");
INSERT INTO artists_table(song, artist) VALUES ("These Walls", "Kendrick Lamar");

INSERT INTO ratings_table(id, username, song, rating) VALUES (1, "Amelia-Earhart", "Freeway", 3);
INSERT INTO ratings_table(id, username, song, rating) VALUES (2, "Amelia-Earhart", "Days of Wine and Roses", 4);
INSERT INTO ratings_table(id, username, song, rating) VALUES (3, "Otto", "Days of Wine and Roses", 5);
INSERT INTO ratings_table(id, username, song, rating) VALUES (4, "Amelia-Earhart", "These Walls", 4);
```

## 3. Getting the PHP Website Setup
Alright, if everything has gone well, you should now have a database within PHPMyAdmin!

Next, we need to move some files from the current file folder this is in.

You'll need to take the following files and COPY THEM into the "htdocs" folder for xampp.

(Depending on your installation, you should be able to reach the folder via C:\xampp\htdocs )

------------------------------------
FILES TO COPY INTO HTDOCS
1. oreo.css
2. boomtreedb.php
------------------------------------

### Connecting to the Boomtree Database

To finish, open up your internet browser and head to http://localhost:8080/boomtree.php!

Once you're there, you should see a nice gradient screen with two forms for the database!

Mess around, register your name, and try to look up some of the pre-installed ones! (Otto and Amelia-Earhart)



