SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

START TRANSACTION;

SET time_zone = '+00:00';

DROP TABLE IF EXISTS `news`;

DROP TABLE IF EXISTS `menu`;

DROP TABLE IF EXISTS `categories`;

DROP TABLE IF EXISTS `episodes`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `datatime` date NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `media_type` varchar(40) NOT NULL DEFAULT 'Фільм',
  `year` int(4) NOT NULL,
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `director` varchar(180) DEFAULT NULL,
  `country` varchar(180) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `trailer` varchar(500) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `season_number` int(11) NOT NULL DEFAULT 1,
  `episode_number` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `menu` (`id`,`title`,`link`,`sort_order`) VALUES
(1,'Головна','index.php',1),
(2,'Фільми','category.php?category_id=1',2),
(3,'Серіали','category.php?category_id=2',3),
(4,'Драми','category.php?category_id=3',4),
(5,'Бойовики','category.php?category_id=4',5);

INSERT INTO `categories` (`id`,`name`,`slug`,`description`) VALUES
(1,'Фільми','films','Повнометражні кінофільми різних жанрів.'),
(2,'Серіали','series','Багатосерійні історії для тривалого перегляду.'),
(3,'Драми','drama','Сюжети з сильними емоціями та глибокими персонажами.'),
(4,'Бойовики','action','Динамічні фільми з пригодами, сутичками та напругою.'),
(5,'Мультфільми','animation','Анімаційні фільми та яскраві історії для різного віку.');

INSERT INTO `news` (`id`,`header`,`content`,`image`,`datatime`,`category_id`,`media_type`,`year`,`rating`,`director`,`country`,`duration`,`trailer`,`featured`) VALUES
(1,'Дюна: Частина друга','Фантастична сага про Пола Атріда, який об’єднується з фременами та проходить шлях від вигнанця до лідера. Фільм поєднує масштабні пустельні сцени, політичні інтриги та боротьбу за майбутнє планети Арракіс.','https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg','2026-05-01',1,'Фільм',2024,8.5,'Дені Вільнев','США, Канада','2 год 46 хв','https://www.youtube.com/watch?v=Way9Dexny3w',1),
(2,'Інтерстеллар','Науково-фантастична історія про групу дослідників, які вирушають крізь космічну червоточину, щоб знайти новий дім для людства. Картина піднімає теми родини, часу, відповідальності та виживання.','https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg','2026-05-02',1,'Фільм',2014,8.7,'Крістофер Нолан','США, Велика Британія','2 год 49 хв','https://www.youtube.com/watch?v=zSWdZVtXT7E',1),
(3,'Оппенгеймер','Біографічна драма про Дж. Роберта Оппенгеймера та створення атомної бомби. Фільм показує складний вибір ученого, наукові відкриття, політичний тиск і наслідки, які змінили світ.','https://image.tmdb.org/t/p/w500/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg','2026-05-03',3,'Фільм',2023,8.1,'Крістофер Нолан','США, Велика Британія','3 год','https://www.youtube.com/watch?v=uYPbbksJxIg',0),
(4,'Бетмен','Темна детективна історія про молодого Брюса Вейна, який розслідує серію злочинів у Ґотемі. Фільм робить акцент на атмосфері нуару, психології героя та корупції міста.','https://image.tmdb.org/t/p/w500/74xTEgt7R36Fpooo50r9T25onhq.jpg','2026-05-04',4,'Фільм',2022,7.7,'Метт Рівз','США','2 год 56 хв','https://www.youtube.com/watch?v=mqqft2x_Aa4',0),
(5,'Аватар: Шлях води','Продовження історії Пандори, де родина Джейка Саллі стикається з новою загрозою та відкриває культуру морського народу. Фільм вирізняється візуальним світом, пригодами та темою захисту сім’ї.','https://image.tmdb.org/t/p/w500/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg','2026-05-05',1,'Фільм',2022,7.6,'Джеймс Кемерон','США','3 год 12 хв','https://www.youtube.com/watch?v=d9MyW72ELq0',0),
(6,'Людина-павук: Навколо всесвіту','Анімаційна супергеройська пригода про Майлза Моралеса, який відкриває мультивсесвіт і зустрічає інших Людей-павуків. Мультфільм має яскравий стиль, гумор та сильну історію дорослішання.','https://image.tmdb.org/t/p/w500/iiZZdoQBEYBv6id8su7ImL0oCbD.jpg','2026-05-06',5,'Мультфільм',2018,8.4,'Боб Персічетті, Пітер Ремзі, Родні Ротман','США','1 год 57 хв','https://www.youtube.com/watch?v=g4Hbz2jLxvQ',0),
(7,'Дивні дива','Серіал про групу друзів з містечка Гокінс, які стикаються з таємничими експериментами, зникненнями та паралельним світом. Атмосфера 80-х поєднана з фантастикою, містикою і пригодами.','https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg','2026-05-07',2,'Серіал',2016,8.6,'Брати Даффер','США','4 сезони','https://www.youtube.com/watch?v=b9EkMc79ZSU',1),
(8,'Останні з нас','Постапокаліптичний серіал про Джоела та Еллі, які подорожують небезпечними США після глобальної катастрофи. Історія поєднує виживання, драму та сильний емоційний зв’язок персонажів.','https://image.tmdb.org/t/p/w500/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg','2026-05-08',2,'Серіал',2023,8.7,'Крейг Мейзін, Ніл Дракманн','США, Канада','1 сезон','https://www.youtube.com/watch?v=uLtkt8BonwM',1),
(9,'Венздей','Комедійно-містичний серіал про Венздей Аддамс, яка навчається в академії Невермор і розслідує загадкові події. У центрі сюжету - сарказм, детектив, надприродні здібності й темна естетика.','https://image.tmdb.org/t/p/w500/jeGtaMwGxPmQN5xM4ClnwPQcNQz.jpg','2026-05-09',2,'Серіал',2022,8.1,'Альфред Гоф, Майлз Міллар','США','1 сезон','https://www.youtube.com/watch?v=Di310WS8zLk',0),
(10,'Пуститися берега','Кримінальна драма про вчителя хімії Волтера Вайта, який після діагнозу змінює своє життя та входить у небезпечний світ наркобізнесу. Серіал відомий розвитком персонажів і напруженим сюжетом.','https://image.tmdb.org/t/p/w500/ztkUQFLlC19CCMYHW9o1zWhJRNq.jpg','2026-05-10',2,'Серіал',2008,8.9,'Вінс Ґілліґан','США','5 сезонів','https://www.youtube.com/watch?v=HhesaQXLuRY',0),
(11,'Відьмак','Фентезі-серіал про мисливця на монстрів Ґеральта з Рівії, чия доля пов’язана з чарівницею Йеннефер і принцесою Цірі. У проєкті є магія, битви, політика та темний фольклор.','https://image.tmdb.org/t/p/w500/cZ0d3rtvXPVvuiX22sP79K3Hmjz.jpg','2026-05-11',2,'Серіал',2019,8.0,'Лорен Шмідт Гіссріх','США, Польща','3 сезони','https://www.youtube.com/watch?v=ndl1W4ltcmg',0),
(12,'Дім дракона','Фентезі-драма про дім Таргарієнів задовго до подій «Гри престолів». Серіал розкриває боротьбу за владу, сімейні конфлікти та політичні інтриги навколо Залізного трону.','https://image.tmdb.org/t/p/w500/z2yahl2uefxDCl0nogcRBstwruJ.jpg','2026-05-12',2,'Серіал',2022,8.4,'Раян Кондал, Джордж Р. Р. Мартін','США','2 сезони','https://www.youtube.com/watch?v=DotnJ7tTA34',0),
(13,'Лост','Після авіакатастрофи пасажири рейсу 815 опиняються на загадковому острові. Вони намагаються вижити, знайти спосіб повернутися додому та поступово розкривають таємниці острова, які змінюють їхнє уявлення про реальність.','https://image.tmdb.org/t/p/w500/og6S0aTZU6YUJAbqxeKjCa3kY1E.jpg','2026-05-13',2,'Серіал',2004,8.3,'Джей Джей Абрамс, Деймон Лінделоф, Карлтон К''юз','США','6 сезонів','https://www.youtube.com/watch?v=KTu8iDynwNc',1);


INSERT INTO `episodes` (`id`,`post_id`,`season_number`,`episode_number`,`title`,`description`,`video_url`) VALUES
(1,13,1,1,'Пілот, частина 1','Початок історії: пасажири рейсу 815 прокидаються після катастрофи на невідомому острові.','https://www.youtube.com/embed/KTu8iDynwNc'),
(2,13,1,2,'Пілот, частина 2','Герої знайомляться ближче й починають розуміти, що острів приховує небезпечні таємниці.','https://www.youtube.com/embed/F7_dkEkE50g'),
(3,13,1,3,'Табула Раса','Перші конфлікти між вцілілими та спроби організувати життя після катастрофи.','https://www.youtube.com/embed/x80aRLFK1x4'),
(4,13,1,4,'Прогулянка','Серія про віру, страхи та особисті таємниці одного з ключових персонажів.','https://www.youtube.com/embed/KTu8iDynwNc'),
(5,13,1,5,'Білий кролик','Пошук відповідей на острові стає дедалі небезпечнішим і дивнішим.','https://www.youtube.com/embed/F7_dkEkE50g');

COMMIT;


