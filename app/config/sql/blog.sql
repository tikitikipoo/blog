

CREATE TABLE IF NOT EXISTS user (
    id INTEGER AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    password VARCHAR(40) NOT NULL,
    created_at DATETIME,
    PRIMARY KEY(id),
    UNIQUE KEY name_index(name)
) ENGINE = INNODB;



CREATE TABLE post(
    id INTEGER AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    title VARCHAR(128),
    body TEXT,
    created_at DATETIME,
    PRIMARY KEY(id),
    INDEX user_id_index(user_id)
) ENGINE = INNODB;

INSERT INTO user (name, password, created_at) values ('123456', '123456', '2014-06-20');

INSERT INTO status (user_id, body, created_at) values (1, 'text sample\n body body', '2014-06-20');