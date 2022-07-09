CREATE SCHEMA IF NOT EXISTS `simple_crud`;

USE `simple_crud`;

CREATE TABLE IF NOT EXISTS `task`
(
    id              INTEGER PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(255) NOT NULL,
    is_completed    boolean      NOT NULL,
    created_at      DATETIME     NOT NULL
);