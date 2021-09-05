USE bookmart;

SELECT * FROM tbl_Login;

SELECT * FROM tbl_Staff WHERE S_fname !="alvin";

CREATE TABLE tbl_category(
categoryId INT NOT NULL AUTO_INCREMENT,
categoryName VARCHAR(20),
PRIMARY KEY (categoryId )
);

CREATE TABLE tbl_subCategory(
subCategoryId INT NOT NULL AUTO_INCREMENT,
subCategoryName VARCHAR(20),
categoryId INT NOT NULL,
PRIMARY KEY(subCategoryId),
FOREIGN KEY (categoryId) REFERENCES tbl_category(categoryId)
);

INSERT INTO tbl_category(categoryName) VALUES
("Electronics"),
("Furnitures"),
("Groceries"),
("Health care"),
("Movies"),
("Music"),
("Software"),
("Games"),
("Toys"),
("Office supply"),
("Utensils"),
("Stationary")
;

INSERT INTO tbl_subCategory(subCategoryName,categoryId) VALUES
("Television",1),
("Laptops",1),
("Cameras",1),
("Printers",1),
("Scanners",1),
("HeadPhones",1),
("HeadSets",1),
("Speakers",1),
("Keyboards",1),
("Mouse",1),
("SmartWatch",1),
("Microphones",1)
;

INSERT INTO tbl_subCategory(subCategoryName,categoryId) VALUES
("Bed",2),
("Computer table",2),
("Bedside table",2),
("Sofa's",2),
("Chair's",2),
("Dining table",2),
("Shelf",2),
("Drawers",2),
("Vegetable cutter",2),
("Portable tables",2),
("Benches",2),
("Study tables",2)
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

