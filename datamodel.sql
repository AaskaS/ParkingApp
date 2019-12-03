CREATE TABLE parkings(
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	name TEXT,
	latitude DECIMAL(10,6),
	longitude DECIMAL(10,6),
	imageurl TEXT,
	description TEXT,
	price DECIMAL(4,2),
	rating SMALLINT UNSIGNED NOT NULL,
	email VARCHAR(320),
	CONSTRAINT pk_parking PRIMARY KEY (id)

);


CREATE TABLE pastspots(
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	s_id INT(11) UNSIGNED NOT NULL,
	email VARCHAR(320),
	CONSTRAINT ps_pastspots PRIMARY KEY(id),
	CONSTRAINT sk_pastspots FOREIGN KEY (s_id) REFERENCES parkings (id) ON DELETE CASCADE;

);

CREATE TABLE register(
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	username VARCHAR(320),
	fname VARCHAR(20),
	lname VARCHAR(20),
	phone VARCHAR(20),
	birthday VARCHAR(10),
	CONSTRAINT rk_register PRIMARY KEY(id)

);


CREATE TABLE requests(
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	r_id INT(11) UNSIGNED NOT NULL,
	customer VARCHAR(20),
	email VARCHAR(320),
	CONSTRAINT pr_requestss PRIMARY KEY(id),
	CONSTRAINT fr_requests FOREIGN KEY (r_id) REFERENCES parkings (id) ON DELETE CASCADE;

);

CREATE TABLE requests(
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	p_id INT(11) UNSIGNED NOT NULL,
	value SMALLINT UNSIGNED NOT NUL
	customer VARCHAR(20),
	description TEXT,
	CONSTRAINT pk_review PRIMARY KEY(id),
	CONSTRAINT fk_review FOREIGN KEY (p_id) REFERENCES parkings (id) ON DELETE CASCADE;

);

CREATE TABLE users(
	username VARCHAR(320),
	salt VARCHAR(64),
	passwordhash VARCHAR(64)

);