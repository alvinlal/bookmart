USE bookmart;

SELECT * FROM tbl_Login;

SELECT * FROM tbl_Staff WHERE S_fname !="alvin";

ALTER TABLE tbl_Category RENAME COLUMN  Cat_Name TO Cat_name;

CREATE TABLE tbl_category(
Cat_id INT NOT NULL AUTO_INCREMENT,
Cat_Name VARCHAR(20),
Cat_status ENUM("active","deleted")  DEFAULT 'active',
PRIMARY KEY (categoryId )
);

CREATE TABLE tbl_SubCategory(
SubCat_Id INT NOT NULL AUTO_INCREMENT,
SubCat_name VARCHAR(20),
Cat_id INT NOT NULL,
SubCat_status ENUM("active","deleted")  DEFAULT 'active',
PRIMARY KEY(SubCat_Id),
FOREIGN KEY (Cat_id) REFERENCES tbl_Category(Cat_id)
);


CREATE TABLE tbl_Author(
    Author_id INT NOT NULL AUTO_INCREMENT,
    A_name VARCHAR(30),
    A_status ENUM("active","deleted")  DEFAULT 'active',
    A_description VARCHAR(200) NOT NULL,
PRIMARY KEY(Author_id),
);


INSERT INTO tbl_Category(categoryName) VALUES
("Art & Music"),
("Biographies"),
("Comics"),
("Education"),
("Novels"),
("History"),
("Self-help"),
("Technology"),
("Hobbies & crafts"),
("Home & garden")
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Art History",1),
("Calligraphy",1),
("Drawing",1),
("Fashion",1),
("Films",1)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Ethnic & Cultural",2),
("Historical",2),
("Leaders & Notable people",2),
("Scientists",2),
("Artists",2)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("DC Comics",3),
("Marvel Comics",3),
("Fantasy",3),
("Manga",3),
("Sci-fi",3)
;


INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Question Banks",4),
("Encyclopedia",4),
("Study Guides",4),
("Law Practise",4),
("Textbooks",4)
;


INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Romance",5),
("Humour",5),
("Fictional",5),
("Mystery",5),
("Thrillers",5)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("African",6),
("Ancient",6),
("Asian",6),
("World War",6),
("Indian",6)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Meditation",7),
("Yoga",7),
("Mental Well Being",7),
("Habits",7),
("Anger Management",7)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Electronics",8),
("Programming",8),
("Databases",8),
("Tech Industry",8),
("Software Development",8)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Antiques & Crafts",9),
("Clay",9),
("Collecting",9),
("Fashion",9),
("Jewellery",9)
;

INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES
("Architecture",10),
("Flowers",10),
("Fruits",10),
("Home decorating",10),
("Interior designing",10)
;






CREATE TABLE tbl_Login(
Username VARCHAR(255),
User_type ENUM('admin','staff','customer'),

User_status ENUM("active","deleted")  DEFAULT 'active',
Password VARCHAR(255) NOT NULL,
PRIMARY KEY (Username)
);

INSERT INTO tbl_Login VALUES(
"[alvinzzz2001@gmail.com](mailto:alvinzzz2001@gmail.com)",
"customer",
"asdfasdf"
);

CREATE TABLE tbl_Customer(
Cust_id INT NOT NULL AUTO_INCREMENT,
Username VARCHAR(255) NOT NULL,
C_phno NUMERIC(10) NOT NULL,
C_fname VARCHAR(25) NOT NULL ,
C_lname VARCHAR(25) NOT NULL,
C_housename VARCHAR(20) NOT NULL,
C_city VARCHAR(20) NOT NULL,
C_district VARCHAR(20) NOT NULL,
C_pin NUMERIC(10) NOT NULL,
PRIMARY KEY (Cust_id),
FOREIGN KEY(Username) REFERENCES tbl_Login(Username)
);

INSERT INTO tbl_Customer(Username,C_phno,C_fname,C_lname,C_housename,C_city,C_district,C_pin)
VALUES('customer@gmail.com',9207248664,'alvin','lal','kutekudiyil','puthencruze','ernakulam',682310);

CREATE table tbl_Vendor(
V_id INT NOT NULL AUTO_INCREMENT,
V_added_by VARCHAR(50) NOT NULL,
V_phno NUMERIC(10) NOT NULL ,
V_email VARCHAR(50) NOT NULL ,
V_name VARCHAR(60) NOT NULL,
V_city VARCHAR(30) NOT NULL,
V_district VARCHAR(30) NOT NULL,
V_pincode VARCHAR(6) NOT NULL,

V_status ENUM('active','deleted') DEFAULT 'active',
PRIMARY KEY (V_id),
FOREIGN KEY (V_added_by) REFERENCES tbl_Login(Username)
);

SELECT V_name,V_city,V_district,V_pincode,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by;

SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username;

CREATE TABLE tbl_Staff(
Staff_id INT NOT NULL AUTO_INCREMENT,
Username VARCHAR(255) NOT NULL,
S_phno NUMERIC(10) NOT NULL,
S_fname VARCHAR(30) NOT NULL,
S_lname VARCHAR(30) NOT NULL,
S_housename VARCHAR(30) NOT NULL,
S_city VARCHAR(30) NOT NULL,
S_district VARCHAR(30) NOT NULL,
S_pin NUMERIC(6) NOT NULL,
S_doj DATE NOT NULL,
PRIMARY KEY (Staff_id),
FOREIGN KEY (Username) REFERENCES tbl_Login(Username)
);

INSERT INTO tbl_Staff (Username,S_fname,S_lname,S_housename,S_city,S_district,S_pin,S_phno,S_doj) VALUES("[staff@bookmart.com](mailto:staff@bookmart.com)","alex","hunter","aston villa","puthencruze","ernakulam",682310,9207248664,"18/01/2001");

SELECT Cust_id,COALESCE(C_fname,'Not Provided') AS C_fname,COALESCE(C_lname,'Not Provided') AS C_lname,COALESCE(C_housename,'Not Provided') AS C_housename,COALESCE(C_city,'Not Provided') AS C_city,COALESCE(C_district,'Not Provided') AS C_district,COALESCE(C_pin,'Not Provided') AS C_pin,COALESCE(C_phno,'Not Provided') AS C_phno,tbl_Login.Username,User_status FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username=tbl_Customer.Username WHERE User_type='customer' ;

