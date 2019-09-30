CREATE TABLE usr 
(
	username varchar(255) PRIMARY KEY,
    password varchar(255) NOT NULL,
    usertype varchar(10) NOT NULL,
    FName varchar(255) NOT NULL,
    LName varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Bdate date,
	Mnumber varchar(255),
	Deleted int(3) NOT NULL
);


CREATE TABLE usr_address 
(
	username varchar(255),
    city varchar(50),
    area_name varchar(50),
    addressID varchar(255),
    address varchar(255) NOT NULL,
    apartmentNo varchar(255),
    floorNo varchar(255),
    comment varchar(8000),
    Deleted int(3) NOT NULL,
    CONSTRAINT PK_usr_address PRIMARY KEY(username,city,area_name,addressID)
);


CREATE TABLE usr_cart
(
    username varchar(255),
    cartId varchar(255),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_usr_cart PRIMARY KEY (username, cartId)
);


CREATE TABLE cart_item
(
	username varchar(255),
    cartId varchar(100),
    rId varchar(255),
    menu varchar(50),
    itemId varchar(255),
    customId varchar(50),
    cnt int(30),
    customization varchar(8000),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_cart_item PRIMARY KEY (username, cartId,rId, menu, itemId, customId)
);

CREATE TABLE city
(
    city varchar(50) PRIMARY KEY,
    deleted int(3) NOT NULL
);


CREATE TABLE area
(
    city varchar(50),
    area_name varchar(50),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_city PRIMARY KEY(city, area_name)
);


CREATE TABLE restaurant
(
	rId varchar(255) PRIMARY KEY,
    rname varchar(255) NOT NULL,
    mnumber varchar(255) NOT NULL,
    imgurl varchar(255),
	active int(3) NOT NULL
);


CREATE TABLE restaurant_cuisine
(
	rId varchar(255),
    cname varchar(255),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_restaurant_cuisine PRIMARY KEY (rId, cname)
);


CREATE TABLE restaurant_branch
(
	rId varchar(255),
    city varchar(50),
    area_name varchar(50),
    bId varchar(255),
    address varchar(255) NOT NULL,
    opening_Hours varchar(255) NOT NULL,
    deleted int(3) NOT NULL,
    CONSTRAINT PK_restaurant_branch PRIMARY KEY (rId, city, area_name,bId)
);


CREATE TABLE branch_darea
(
	rId varchar(255),
    bId varchar(255),
    city varchar(50),
    area_name varchar(50),
	delivery_charge decimal(10,4),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_restaurant_darea PRIMARY KEY (rId, city, area_name,bId)
);


CREATE TABLE menu
(
	rId varchar(255),
    menu varchar(255),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_menu PRIMARY KEY (rId, menu)
);


CREATE TABLE item
(
	rId varchar(255),
    menu varchar(255),
 	itemId varchar(255),
    item_name varchar (255) NOT NULL, 
    description varchar(8000),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_item PRIMARY KEY (rId, menu, itemId)
);


CREATE TABLE item_custom
(
	rId varchar(255),
    menu varchar(255),
 	itemId varchar(255),
    customId varchar(50),
    description varchar(8000),
    price decimal(10,4),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_item_custom PRIMARY KEY (rId, menu, itemId, customId)
);


CREATE TABLE ordr
(
	username varchar(255),
    cartId varchar(255),
 	orderId varchar(255),
    
    
    city varchar(50) NOT NULL,
    area_name varchar(50) NOT NULL,
    addressID varchar(255) NOT NULL,
    
    status varchar(255) NOT NULL,
    rate decimal(2,2),
    
    deleted int(3) NOT NULL,
    CONSTRAINT PK_ordr PRIMARY KEY (username, cartId, orderId)
);


CREATE TABLE change_password
(
    adminId varchar(255),
    userId varchar(255),
    cpId varchar(255),
    date_changed date NOT NULL,
    old_pass varchar(255) NOT NULL,
    constraint PK_change_password PRIMARY KEY (adminId, userId, cpId)
);


CREATE TABLE delete_usr
(
    adminId varchar(255),
    userId varchar(255),
    date_deleted date NOT NULL,
    constraint PK_delete_usr PRIMARY KEY (adminId, userId)
);


CREATE TABLE add_usr
(
    adminId varchar(255),
    userId varchar(255),
    date_added date NOT NULL,
    constraint PK_add_usr PRIMARY KEY (adminId, userId)
);


CREATE TABLE promocode
(
    promoId varchar(255) PRIMARY KEY,
    discount decimal (3,3),
    sdate date NOT NULL,
    edate date
);


CREATE TABLE promocode_usr
(
    promoId varchar(255),
    username varchar(255),
    times_used int(10),
    CONSTRAINT PK_promocode_usr PRIMARY KEY (promoId, username)
);


CREATE TABLE promocode_restaurant
(
    promoId varchar(255),
    rId varchar(255),
    times int(10),
    CONSTRAINT PK_promocode_restaurant PRIMARY KEY (promoId, rId)
);



ALTER TABLE usr_address ADD CONSTRAINT FK_user_address_username FOREIGN KEY (username) REFERENCES usr (username);
ALTER TABLE usr_address ADD CONSTRAINT FK_user_address_city FOREIGN KEY (city) REFERENCES city(city);
ALTER TABLE usr_address ADD CONSTRAINT FK_user_address_area_name FOREIGN KEY (area_name) REFERENCES area(area_name);

ALTER TABLE usr_cart ADD CONSTRAINT FK_usr_cart_username FOREIGN KEY (username) REFERENCES usr (username);


ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_username FOREIGN KEY (username) REFERENCES usr (username);
ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_cartId FOREIGN KEY (cartId) REFERENCES cart_usr(cartId);
ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_rId FOREIGN KEY (rId) REFERENCES item(rId);
ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_menu FOREIGN KEY (menu) REFERENCES item(menu);
ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_itemId FOREIGN KEY (itemId) REFERENCES item(itemId);
ALTER TABLE cart_item ADD CONSTRAINT FK_cart_item_customId FOREIGN KEY (customId) REFERENCES item_custom (customId);


ALTER TABLE area ADD CONSTRAINT FK_area_city FOREIGN KEY (city) REFERENCES city (city);

ALTER TABLE restaurant_cuisine ADD CONSTRAINT FK_restaurant_cuisine_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);

ALTER TABLE restaurant_branch ADD CONSTRAINT FK_restaurant_branch_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);
ALTER TABLE restaurant_branch ADD CONSTRAINT FK_restaurant_branch_city FOREIGN KEY (city) REFERENCES city (city);
ALTER TABLE restaurant_branch ADD CONSTRAINT FK_restaurant_branch_area_name FOREIGN KEY (area_name) REFERENCES area (area_name);

ALTER TABLE branch_darea ADD CONSTRAINT FK_branch_darea_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);
ALTER TABLE branch_darea ADD CONSTRAINT FK_branch_darea_bId FOREIGN KEY (bId) REFERENCES restaurant_branch (bId);
ALTER TABLE branch_darea ADD CONSTRAINT FK_branch_darea_city FOREIGN KEY (city) REFERENCES city (city);
ALTER TABLE branch_darea ADD CONSTRAINT FK_branch_darea_area_name FOREIGN KEY (area_name) REFERENCES area (area_name);

ALTER TABLE menu ADD CONSTRAINT FK_menu_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);

ALTER TABLE item ADD CONSTRAINT FK_item_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);
ALTER TABLE item ADD CONSTRAINT FK_item_menu FOREIGN KEY (menu) REFERENCES menu (menu);

ALTER TABLE item_custom ADD CONSTRAINT FK_item_custom_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);
ALTER TABLE item_custom ADD CONSTRAINT FK_item_custom_menu FOREIGN KEY (menu) REFERENCES menu (menu);
ALTER TABLE item_custom ADD CONSTRAINT FK_item_custom_itemId FOREIGN KEY (itemId) REFERENCES item (itemId);

ALTER TABLE ordr ADD CONSTRAINT FK_ordr_username FOREIGN KEY (username) REFERENCES usr (username);
ALTER TABLE ordr ADD CONSTRAINT FK_ordr_cartId FOREIGN KEY (cartId) REFERENCES usr_cart (cartId);
ALTER TABLE ordr ADD CONSTRAINT FK_ordr_city FOREIGN KEY (city) REFERENCES city (city);
ALTER TABLE ordr ADD CONSTRAINT FK_ordr_area_name FOREIGN KEY (area_name) REFERENCES area (area_name);
ALTER TABLE ordr ADD CONSTRAINT FK_ordr_addressId FOREIGN KEY (addressId) REFERENCES usr_address (addressId);

ALTER TABLE change_password ADD CONSTRAINT FK_change_password_adminId FOREIGN KEY (adminId) REFERENCES usr (username);
ALTER TABLE change_password ADD CONSTRAINT FK_change_password_userId FOREIGN KEY (userId) REFERENCES usr (username);

ALTER TABLE delete_usr ADD CONSTRAINT FK_delete_usr_adminId FOREIGN KEY (adminId) REFERENCES usr (username);
ALTER TABLE delete_usr ADD CONSTRAINT FK_delete_usr_userId FOREIGN KEY (userId) REFERENCES usr (username);

ALTER TABLE add_usr ADD CONSTRAINT FK_add_usr_adminId FOREIGN KEY (adminId) REFERENCES usr (username);
ALTER TABLE add_usr ADD CONSTRAINT FK_add_usr_userId FOREIGN KEY (userId) REFERENCES usr (username);

ALTER TABLE promocode_usr ADD CONSTRAINT FK_promocode_usr_promoId FOREIGN KEY (promoId) REFERENCES promocode (promoId);
ALTER TABLE promocode_usr ADD CONSTRAINT FK_promocode_usr_username FOREIGN KEY (username) REFERENCES usr (username);

ALTER TABLE promocode_restaurant ADD CONSTRAINT FK_promocode_restaurant_promoId FOREIGN KEY (promoId) REFERENCES promocode (promoId);
ALTER TABLE promocode_restaurant ADD CONSTRAINT FK_promocode_restaurant_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);


CREATE TABLE staff_rest
(
    username varchar(255),
    rId varchar(255),
    deleted int(3) NOT NULL,
    CONSTRAINT PK_usr_cart PRIMARY KEY (username, rId)
);

ALTER TABLE staff_rest ADD CONSTRAINT FK_staff_rest_username FOREIGN KEY (username) REFERENCES usr (username);
ALTER TABLE staff_rest ADD CONSTRAINT FK_staff_rest_rId FOREIGN KEY (rId) REFERENCES restaurant (rId);

ALTER TABLE promocode ADD deleted INT(3) NOT NULL;

ALTER TABLE ordr ADD promocode VARCHAR(255) NULL;
