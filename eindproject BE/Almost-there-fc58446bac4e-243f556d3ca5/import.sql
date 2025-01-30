DROP DATABASE IF EXISTS `beindproject`;
CREATE DATABASE `beindproject`;
USE  `beindproject`;

DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS persona;
DROP TABLE IF EXISTS users;

CREATE TABLE cart (
  user_id int(11) NOT NULL,
  persona_id int(11) NOT NULL,
  amount int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;








CREATE TABLE persona (
  id int(11) NOT NULL,
  name varchar(255) DEFAULT NULL,
  arcana varchar(255) DEFAULT NULL,
  inherits varchar(255) DEFAULT NULL,
  price int(11) DEFAULT NULL,
  level int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO persona (id, name, arcana, inherits, price, level) VALUES
(1, 'Orpheus', 'Fool', 'Pierce', 12, 1),
(2, 'Thanatos', 'Death', 'Strike', 24, 4),
(3, 'Izanagi', 'Fool', 'Electric', 36, 9),
(4, 'Messiah', 'Judgement', 'Almighty', 42, 13),
(5, 'Arsene', 'Fool', 'Slash', 48, 14),
(6, 'Surt', 'Magician', 'Fire', 52, 15),
(7, 'Loki', 'Magician', 'Fire', 56, 17),
(8, 'Thor', 'Chariot', 'Electric', 58, 18),
(9, 'Siegfried', 'Strength', 'Slash', 63, 21),
(10, 'Futsunushi', 'Tower', 'Slash', 65, 23),
(11, 'Oberon', 'Emperor', 'Ice', 67, 28),
(12, 'Titania', 'Empress', 'Ice', 69, 31),
(13, 'Cu Chulainn', 'Hierophant', 'Pierce', 72, 36),
(14, 'Apsaras', 'Priestess', 'Ice', 75, 38),
(15, 'Unicorn', 'Priestess', 'Healing', 78, 41),
(16, 'Mothman', 'Hermit', 'Electric', 80, 45),
(17, 'Ares', 'Chariot', 'Slash', 88, 60),
(18, 'Isis', 'Empress', 'Ice', 92, 73),
(19, 'Nigi Mitama', 'Temperance', 'Healing', 96, 80),
(20, 'Mithra', 'Sun', 'Fire', 100, 82),
(21, 'Take-Mikazuchi', 'Emperor', 'Electric', 103, 92),
(22, 'King Frost', 'Emperor', 'Ice', 112, 96),
(23, 'Valkyrie', 'Strength', 'Strike', 115, 98),
(24, 'Narcissus', 'Lovers', 'Pierce', 119, 100),
(25, 'Queen Mab', 'Empress', 'Ice', 121, 101),
(26, 'Kikuri-Hime', 'Priestess', 'Healing', 124, 104),
(27, 'Yatagarasu', 'Sun', 'Electric', 127, 108),
(28, 'Rangda', 'Magician', 'Fire', 132, 112),
(29, 'Decarabia', 'Fool', 'Fire', 134, 116),
(30, 'Vishnu', 'Fool', 'Electric', 138, 121),
(31, 'Chi You', 'Moon', 'Pierce', 141, 129),
(32, 'Ara Mitama', 'Chariot', 'Fire', 146, 132),
(33, 'Scathach', 'Death', 'Fire', 150, 143),
(34, 'Shiva', 'Tower', 'Ice', 154, 150),
(35, 'Asura', 'Sun', 'Fire', 158, 153),
(36, 'Odin', 'Emperor', 'Electric', 160, 155),
(37, 'Alice', 'Death', 'Dark', 167, 157),
(38, 'Black Frost', 'Fool', 'Ice', 170, 159);



CREATE TABLE users (
  id int(11) NOT NULL,
  role enum('user','admin') DEFAULT 'user',
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;






INSERT INTO users (id, role, username, password) VALUES
(1, 'admin', 'dean', '$2y$10$SJpAztkvGbFo2vr01ACRReLCvtr21NSxYDMRV2bogGSsSinQHpGqK'),
(2, 'user', 'dean1', '$2y$10$U4lDVEzk2tKGtVDOTXiSvuFBqT.yjoZcUD.VBZhT2BPc.SQnBbHjy'),
(3, 'user', 'deano', '$2y$10$gwYG2BgdV8hlPKwGflZmWu2XhDkabfNwXOgmmFBK8GXWeWIaBuyS.');

ALTER TABLE cart
  ADD PRIMARY KEY (user_id,persona_id);


ALTER TABLE persona
  ADD PRIMARY KEY (id);

ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY username (username);


ALTER TABLE persona
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;


ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;