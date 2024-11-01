-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 05, 2024 at 12:52 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name_uz` varchar(100) DEFAULT NULL,
  `name_oz` varchar(100) DEFAULT NULL,
  `name_ru` varchar(100) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `region_id`, `name_uz`, `name_oz`, `name_ru`, `name_en`) VALUES
(15, 1, 'Amudaryo tumani', 'Амударё тумани', 'Амударьинский район', 'Amudarya district'),
(16, 1, 'Beruniy tumani', 'Беруний тумани', 'Берунийский район', 'Beruniy district'),
(17, 1, 'Kegayli tumani', 'Кегайли тумани', 'Кегейлийский район', 'Kegeyli district'),
(18, 1, 'Qonliko‘l tumani', 'Қонликўл тумани', 'Канлыкульский район', 'Qonliko‘l district'),
(19, 1, 'Qorao‘zak tumani', 'Қораўзак тумани', 'Караузякский район', 'Qorao‘zak district'),
(20, 1, 'Qo‘ng‘irot tumani', 'Қўнғирот тумани', 'Кунградский район', 'Qo‘ng‘irot district'),
(21, 1, 'Mo‘ynoq tumani', 'Мўйноқ тумани', 'Муйнакский район', 'Mo‘ynoq district'),
(22, 1, 'Nukus tumani', 'Нукус тумани', 'Нукусский район', 'Nukus district'),
(23, 1, 'Nukus shahri', 'Нукус шаҳри', 'город Нукус', 'Nukus city'),
(24, 1, 'Taxtako‘pir tumani', 'Тахтакўпир тумани', 'Тахтакупырский район', 'Taxtakopir district'),
(25, 1, 'To‘rtko‘l tumani', 'Тўрткўл тумани', 'Турткульский район', 'To‘rtko‘l district'),
(26, 1, 'Xo‘jayli tumani', 'Хўжайли тумани', 'Ходжейлийский район', 'Xo‘jayli district'),
(27, 1, 'Chimboy tumani', 'Чимбой тумани', 'Чимбайский район', 'Chimboy district'),
(28, 1, 'Shumanay tumani', 'Шуманай тумани', 'Шуманайский район', 'Shumanay district'),
(29, 1, 'Ellikqal‘a tumani', 'Элликқалъа тумани', 'Элликкалинский район', 'Ellikqal‘a district'),
(30, 2, 'Andijon shahri', 'Андижон шаҳри', 'город Андижан', 'Andijon city'),
(31, 2, 'Andijon tumani', 'Андижон тумани', 'Андижанский район', 'Andijon district'),
(32, 2, 'Asaka tumani', 'Асака тумани', 'Асакинский район', 'Asaka district'),
(33, 2, 'Baliqchi tumani', 'Балиқчи тумани', 'Балыкчинский район', 'Baliqchi district'),
(34, 2, 'Buloqboshi tumani', 'Булоқбоши тумани', 'Булакбашинский район', 'Buloqboshi district'),
(35, 2, 'Bo‘z tumani', 'Бўз тумани', 'Бозский район', 'Bo‘z district'),
(36, 2, 'Jalaquduq tumani', 'Жалақудуқ тумани', 'Джалакудукский район', 'Jalaquduq district'),
(37, 2, 'Izbosgan tumani', 'Избосган тумани', 'Избасканский район', 'Izbosgan district'),
(38, 2, 'Qorasuv shahri', 'Қорасув шаҳри', 'город Карасув', 'Qorasuv city'),
(39, 2, 'Qo‘rg‘ontepa tumani', 'Қўрғонтепа тумани', 'Кургантепинский район', 'Qo‘rg‘ontepa district'),
(40, 2, 'Marhamat tumani', 'Марҳамат тумани', 'Мархаматский район', 'Marhamat district'),
(41, 2, 'Oltinko‘l tumani', 'Олтинкўл тумани', 'Алтынкульский район', 'Oltinqo‘l district'),
(42, 2, 'Paxtaobod tumani', 'Пахтаобод тумани', 'Пахтаабадский район', 'Paxtachi district'),
(43, 2, 'Ulug‘nor tumani', 'Улуғнор тумани', 'Улугнорский район', 'Ulug‘nor district'),
(44, 2, 'Xonabod tumani', 'Хонабод тумани', 'город Ханабад', 'Xonobod district '),
(45, 2, 'Xo‘jaobod tumani', 'Хўжаобод тумани', 'Ходжаабадский район', 'Xo‘jaobod district'),
(46, 2, 'Shaxrixon tumani', 'Шахрихон тумани', 'Шахриханский район', 'Shaxrixon district'),
(47, 3, 'Buxoro shahri', 'Бухоро шаҳри', 'город Бухара', 'Buxoro city'),
(48, 3, 'Buxoro tumani', 'Бухоро тумани', 'Бухарский район', 'Buxoro district'),
(49, 3, 'Vobkent tumani', 'Вобкент тумани', 'Вабкентский район', 'Vobkent district'),
(50, 3, 'G‘ijduvon tumani', 'Ғиждувон тумани', 'Гиждуванский район', 'G‘ijduvon district'),
(51, 3, 'Jondor tumani', 'Жондор тумани', 'Жондорский район', 'Jondor district'),
(52, 3, 'Kogon tumani', 'Когон тумани', 'Каганский район', 'Kogon district'),
(53, 3, 'Kogon shahri', 'Когон шаҳри', 'город Каган', 'Kogon city'),
(54, 3, 'Qorako‘l tumani', 'Қоракўл тумани', 'Каракульский район', 'Qorako‘l district'),
(55, 3, 'Qorovulbozor tumani', 'Қоровулбозор тумани', 'Караулбазарский район', 'Qorovulbozor district'),
(56, 3, 'Olot tumani', 'Олот тумани', 'Алатский район', 'Olot district'),
(57, 3, 'Peshku tumani', 'Пешку тумани', 'Пешкунский район', 'Peshku district'),
(58, 3, 'Romitan tumani', 'Ромитан тумани', 'Ромитанский район', 'Romitan district'),
(59, 3, 'Shofirkon tumani', 'Шофиркон тумани', 'Шафирканский район', 'Shofirkon district'),
(60, 4, 'Arnasoy tumani', 'Арнасой тумани', 'Арнасайский район', 'Arnasoy district'),
(61, 4, 'Baxmal tumani', 'Бахмал тумани', 'Бахмальский район', 'Baxmal district'),
(62, 4, 'G‘allaorol tumani', 'Ғаллаорол тумани', 'Галляаральский район', 'G‘allaorol district'),
(63, 4, 'Do‘stlik tumani', 'Дўстлик тумани', 'Дустликский район', 'Do‘stlik district'),
(64, 4, 'Sh.Rashidov tumani', 'Ш.Рашидов тумани', 'Шараф-Рашидовский район', 'Sh.Rashidov district'),
(65, 4, 'Jizzax shahri', 'Жиззах шаҳри', 'город Джизак', 'Jizzax city'),
(66, 4, 'Zarbdor tumani', 'Зарбдор тумани', 'Зарбдарский район', 'Zarbdor district'),
(67, 4, 'Zafarobod tumani', 'Зафаробод тумани', 'Зафарабадский район', 'Zafarobod district'),
(68, 4, 'Zomin tumani', 'Зомин тумани', 'Зааминский район', 'Zomin district'),
(69, 4, 'Mirzacho‘l tumani', 'Мирзачўл тумани', 'Мирзачульский район', 'Mirzacho‘l district'),
(70, 4, 'Paxtakor tumani', 'Пахтакор тумани', 'Пахтакорский район', 'Paxtakor district'),
(71, 4, 'Forish tumani', 'Фориш тумани', 'Фаришский район', 'Forish district'),
(72, 4, 'Yangiobod tumani', 'Янгиобод тумани', 'Янгиабадский район', 'Yangiobod district'),
(73, 5, 'G‘uzor tumani', 'Ғузор тумани', 'Гузарский район', 'G‘uzor district'),
(74, 5, 'Dehqonobod tumani', 'Деҳқонобод тумани', 'Дехканабадский район', 'Dehqonobod district'),
(75, 5, 'Qamashi tumani', 'Қамаши тумани', 'Камашинский район', 'Qamashi district'),
(76, 5, 'Qarshi tumani', 'Қарши тумани', 'Каршинский район', 'Qarshi district'),
(77, 5, 'Qarshi shahri', 'Қарши шаҳри', 'город Карши', 'Qarshi city'),
(78, 5, 'Kasbi tumani', 'Касби тумани', 'Касбийский район', 'Kasbi district'),
(79, 5, 'Kitob tumani', 'Китоб тумани', 'Китабский район', 'Kitob district'),
(80, 5, 'Koson tumani', 'Косон тумани', 'Касанский район', 'Koson district'),
(81, 5, 'Mirishkor tumani', 'Миришкор тумани', 'Миришкорский район', 'Mirishkor district'),
(82, 5, 'Muborak tumani', 'Муборак тумани', 'Мубарекский район', 'Muborak district'),
(83, 5, 'Nishon tumani', 'Нишон тумани', 'Нишанский район', 'Nishon district'),
(84, 5, 'Chiroqchi tumani', 'Чироқчи тумани', 'Чиракчинский район', 'Chiroqchi district'),
(85, 5, 'Shahrisabz tumani', 'Шаҳрисабз тумани', 'Шахрисабзский район', 'Shahrisabz district'),
(86, 5, 'Yakkabog‘ tumani', 'Яккабоғ тумани', 'Яккабагский район', 'Yakkabog‘ district'),
(87, 6, 'Zarafshon shahri', 'Зарафшон шаҳри', 'город Зарафшан', 'Zarafshon city'),
(88, 6, 'Karman tumani', 'Карман тумани', 'Карманинский район', 'Karman district'),
(89, 6, 'Qiziltepa tumani', 'Қизилтепа тумани', 'Кызылтепинский район', 'Qiziltepa district'),
(90, 6, 'Konimex tumani', 'Конимех тумани', 'Канимехский район', 'Konimex district'),
(91, 6, 'Navbahor tumani', 'Навбаҳор тумани', 'Навбахорский район', 'Navbahor district'),
(92, 6, 'Navoiy shahri', 'Навоий шаҳри', 'город Навои', 'Navoiy city'),
(93, 6, 'Nurota tumani', 'Нурота тумани', 'Нуратинский район', 'Nurota district'),
(94, 6, 'Tomdi tumani', 'Томди тумани', 'Тамдынский район', 'Tomdi district'),
(95, 6, 'Uchquduq tumani', 'Учқудуқ тумани', 'Учкудукский район', 'Uchquduq district'),
(96, 6, 'Xatirchi tumani', 'Хатирчи тумани', 'Хатырчинский район', 'Xatirchi district'),
(97, 7, 'Kosonsoy tumani', 'Косонсой тумани', 'Касансайский район', 'Kosonsoy district'),
(98, 7, 'Mingbuloq tumani', 'Мингбулоқ тумани', 'Мингбулакский район', 'Mingbuloq district'),
(99, 7, 'Namangan tumani', 'Наманган тумани', 'Наманганский район', 'Namangan district'),
(100, 7, 'Namangan shahri', 'Наманган шаҳри', 'город Наманган', 'Namangan city'),
(101, 7, 'Norin tumani', 'Норин тумани', 'Нарынский район', 'Norin district'),
(102, 7, 'Pop tumani', 'Поп тумани', 'Папский район', 'Pop district'),
(103, 7, 'To‘raqo‘rg‘on tumani', 'Тўрақўрғон тумани', 'Туракурганский район', 'To‘raqo‘rg‘on district'),
(104, 7, 'Uychi tumani', 'Уйчи тумани', 'Уйчинский район', 'Uychi district'),
(105, 7, 'Uchqo‘rg‘on tumani', 'Учқўрғон тумани', 'Учкурганский район', 'Uchqo‘rg‘on district'),
(106, 7, 'Chortoq tumani', 'Чортоқ тумани', 'Чартакский район', 'Chortoq district'),
(107, 7, 'Chust tumani', 'Чуст тумани', 'Чустский район', 'Chust district'),
(108, 7, 'Yangiqo‘rg‘on tumani', 'Янгиқўрғон тумани', 'Янгикурганский район', 'Yangiqo‘rg‘on district'),
(109, 8, 'Bulung‘ur tumani', 'Булунғур тумани', 'Булунгурский район', 'Bulung‘ur district'),
(110, 8, 'Jomboy tumani', 'Жомбой тумани', 'Джамбайский район', 'Jomboy district'),
(111, 8, 'Ishtixon tumani', 'Иштихон тумани', 'Иштыханский район', 'Ishtixon district'),
(112, 8, 'Kattaqo‘rg‘on tumani', 'Каттақўрғон тумани', 'Каттакурганский район', 'Kattaqo‘rg‘on district'),
(113, 8, 'Kattaqo‘rg‘on shahri', 'Каттақўрғон шаҳри', 'город Каттакурган', 'Kattaqo‘rg‘on city'),
(114, 8, 'Qo‘shrabot tumani', 'Қўшработ тумани', 'Кошрабадский район', 'Qo‘shrabot district'),
(115, 8, 'Narpay tumani', 'Нарпай тумани', 'Нарпайский район', 'Narpay district'),
(116, 8, 'Nurabod tumani', 'Нурабод тумани', 'Нурабадский район', 'Nurabod district'),
(117, 8, 'Oqdaryo tumani', 'Оқдарё тумани', 'Акдарьинский район', 'Okdaryo district'),
(118, 8, 'Payariq tumani', 'Паяриқ тумани', 'Пайарыкский район', 'Payariq district'),
(119, 8, 'Pastarg‘om tumani', 'Пастарғом тумани', 'Пастдаргомский район', 'Pastarg‘om district'),
(120, 8, 'Paxtachi tumani', 'Пахтачи тумани', 'Пахтачийский район', 'Paxtachi district'),
(121, 8, 'Samarqand tumani', 'Самарқанд тумани', 'Самаркандский район', 'Samarqand district'),
(122, 8, 'Samarqand shahri', 'Самарқанд шаҳри', 'город Самарканд', 'Samarqand city'),
(123, 8, 'Toyloq tumani', 'Тойлоқ тумани', 'Тайлакский район', 'Toyloq district'),
(124, 8, 'Urgut tumani', 'Ургут тумани', 'Ургутский район', 'Urgut district'),
(125, 9, 'Angor tumani', 'Ангор тумани', 'Ангорский район', 'Angor district'),
(126, 9, 'Boysun tumani', 'Бойсун тумани', 'Байсунский район', 'Boysun district'),
(127, 9, 'Denov tumani', 'Денов тумани', 'Денауский район', 'Denov district'),
(128, 9, 'Jarqo‘rg‘on tumani', 'Жарқўрғон тумани', 'Джаркурганский район', 'Jarqo‘rg‘on district'),
(129, 9, 'Qiziriq tumani', 'Қизириқ тумани', 'Кизирикский район', 'Qiziriq district'),
(130, 9, 'Qo‘mqo‘rg‘on tumani', 'Қўмқўрғон тумани', 'Кумкурганский район', 'Qo‘mqo‘rg‘on district'),
(131, 9, 'Muzrabot tumani', 'Музработ тумани', 'Музрабадский район', 'Muzrabot district'),
(132, 9, 'Oltinsoy tumani', 'Олтинсой тумани', 'Алтынсайский район', 'Oltinsoy district'),
(133, 9, 'Sariosiy tumani', 'Сариосий тумани', 'Сариасийский район', 'Sariosiy district'),
(134, 9, 'Termiz tumani', 'Термиз тумани', 'Термезский район', 'Termiz district'),
(135, 9, 'Termiz shahri', 'Термиз шаҳри', 'город Термез', 'Termiz city'),
(136, 9, 'Uzun tumani', 'Узун тумани', 'Узунский район', 'Uzun district'),
(137, 9, 'Sherobod tumani', 'Шеробод тумани', 'Шерабадский район', 'Sherobod district'),
(138, 9, 'Sho‘rchi tumani', 'Шўрчи тумани', 'Шурчинский район', 'Sho‘rchi district'),
(139, 10, 'Boyovut tumani', 'Боёвут тумани', 'Баяутский район', 'Boyovut district'),
(140, 10, 'Guliston tumani', 'Гулистон тумани', 'Гулистанский район', 'Guliston district'),
(141, 10, 'Guliston shahri', 'Гулистон шаҳри', 'город Гулистан', 'Guliston city'),
(142, 10, 'Mirzaobod tumani', 'Мирзаобод тумани', 'Мирзаабадский район', 'Mirzaobod district'),
(143, 10, 'Oqoltin tumani', 'Оқолтин тумани', 'Акалтынский район', 'Oqoltin district'),
(144, 10, 'Sayxunobod tumani', 'Сайхунобод тумани', 'Сайхунабадский район', 'Sayxunobod district'),
(145, 10, 'Sardoba tumani', 'Сардоба тумани', 'Сардобский район', 'Sardoba district'),
(146, 10, 'Sirdaryo tumani', 'Сирдарё тумани', 'Сырдарьинский район', 'Sirdaryo district'),
(147, 10, 'Xavos tumani', 'Хавос тумани', 'Хавастский район', 'Xavos district'),
(148, 10, 'Shirin shahri', 'Ширин шаҳри', 'город Ширин', 'Shirin city'),
(149, 10, 'Yangiyer shahri', 'Янгиер шаҳри', 'город Янгиер', 'Yangiyer city'),
(150, 11, 'Angiren shahri', 'Ангирен шаҳри', 'город Ангрен', 'Angiren city'),
(151, 11, 'Bekabod tumani', 'Бекабод тумани', 'Бекабадский район', 'Bekobod district'),
(152, 11, 'Bekabod shahri', 'Бекабод шаҳри', 'город Бекабад', 'Bekobod city'),
(153, 11, 'Bo‘ka tumani', 'Бўка тумани', 'Букинский район', 'Bo‘ka district'),
(154, 11, 'Bo‘stonliq tumani', 'Бўстонлиқ тумани', 'Бостанлыкский район', 'Bo‘stonliq district'),
(155, 11, 'Zangiota tumani', 'Зангиота тумани', 'Зангиатинский район', 'Zangiota district'),
(156, 11, 'Qibray tumani', 'Қибрай тумани', 'Кибрайский район', 'Qibray district'),
(157, 11, 'Quyichirchiq tumani', 'Қуйичирчиқ тумани', 'Куйичирчикский район', 'Quyichirchiq district'),
(158, 11, 'Oqqo‘rg‘on tumani', 'Оққўрғон тумани', 'Аккурганский район', 'Oqqo‘rg‘on district'),
(159, 11, 'Olmaliq shahri', 'Олмалиқ шаҳри', 'город Алмалык', 'Olmaliq city'),
(160, 11, 'Ohangaron tumani', 'Оҳангарон тумани', 'Ахангаранский район', 'Ohangaron district'),
(161, 11, 'Parkent tumani', 'Паркент тумани', 'Паркентский район', 'Parkent district'),
(162, 11, 'Piskent tumani', 'Пискент тумани', 'Пскентский район', 'Piskent district'),
(163, 11, 'O‘rtachirchiq tumani', 'Ўртачирчиқ тумани', 'Уртачирчикский район', 'O‘rtachirchiq district'),
(164, 11, 'Chinoz tumani', 'Чиноз тумани', 'Чиназский район', 'Chinoz district'),
(165, 11, 'Chirchiq shahri', 'Чирчиқ шаҳри', 'город Чирчик', 'Chirchiq city'),
(166, 11, 'Yuqorichirchiq tumani', 'Юқоричирчиқ тумани', 'Юкоричирчикский район', 'Yuqorichirchiq district'),
(167, 11, 'Yangiyo‘l tumani', 'Янгийўл тумани', 'Янгиюльский район', 'Yangiyo‘l district'),
(168, 12, 'Beshariq tumani', 'Бешариқ тумани', 'Бешарыкский район', 'Beshariq district'),
(169, 12, 'Bog‘dod tumani', 'Боғдод тумани', 'Багдадский район', 'Bog‘dod district'),
(170, 12, 'Buvayda tumani', 'Бувайда тумани', 'Бувайдинский район', 'Buvayda district'),
(171, 12, 'Dang‘ara tumani', 'Данғара тумани', 'Дангаринский район', 'Dang‘ara district'),
(172, 12, 'Yozyovon tumani', 'Ёзёвон тумани', 'Язъяванский район', 'Yozyovon district'),
(173, 12, 'Quva tumani', 'Қува тумани', 'Кувинский район', 'Quva district'),
(174, 12, 'Quvasoy shahri', 'Қувасой шаҳри', 'город Кувасай', 'Quvasoy city'),
(175, 12, 'Qo‘qon shahri', 'Қўқон шаҳри', 'город Коканд', 'Qo‘qon city'),
(176, 12, 'Qo‘shtepa tumani', 'Қўштепа тумани', 'Куштепинский район', 'Qo‘shtepa district'),
(177, 12, 'Marg‘ilon shahri', 'Марғилон шаҳри', 'город Маргилан', 'Marg‘ilon city'),
(178, 12, 'Oltiariq tumani', 'Олтиариқ тумани', 'Алтыарыкский район', 'Altiariq district'),
(179, 12, 'Rishton tumani', 'Риштон тумани', 'Риштанский район', 'Rishton district'),
(180, 12, 'So‘x tumani', 'Сўх тумани', 'Сохский район', 'So‘x district'),
(181, 12, 'Toshloq tumani', 'Тошлоқ тумани', 'Ташлакский район', 'Toshloq district'),
(182, 12, 'Uchko‘prik tumani', 'Учкўприк тумани', 'Учкуприкский район', 'Uchko‘prik district'),
(183, 12, 'O‘zbekiston tumani', 'Ўзбекистон тумани', 'Узбекистанский район', 'O‘zbekiston district'),
(184, 12, 'Farg‘ona tumani', 'Фарғона тумани', 'Ферганский район', 'Farg‘ona district'),
(185, 12, 'Farg‘ona shahri', 'Фарғона шаҳри', 'город Фергана', 'Farg‘ona city'),
(186, 12, 'Furqat tumani', 'Фурқат тумани', 'Фуркатский район', 'Furqat district'),
(187, 13, 'Bog‘ot tumani', 'Боғот тумани', 'Багатский район', 'Bog‘ot district'),
(188, 13, 'Gurlan tumani', 'Гурлан тумани', 'Гурленский район', 'Gurlan district'),
(189, 13, 'Qo‘shko‘pir tumani', 'Қўшкўпир тумани', 'Кошкупырский район', 'Qo‘shko‘pir district'),
(190, 13, 'Urganch tumani', 'Урганч тумани', 'Ургенчский район', 'Urganch district'),
(191, 13, 'Urganch shahri', 'Урганч шаҳри', 'город Ургенч', 'Urganch city'),
(192, 13, 'Xiva tumani', 'Хива тумани', 'Хивинский район', 'Khiva district'),
(193, 13, 'Xazarasp tumani', 'Хазарасп тумани', 'Хазараспский район', 'Xazarasp district'),
(194, 13, 'Xonqa tumani', 'Хонқа тумани', 'Ханкинский район', 'Xonqa district'),
(195, 13, 'Shavot tumani', 'Шавот тумани', 'Шаватский район', 'Shavot district'),
(196, 13, 'Yangiariq tumani', 'Янгиариқ тумани', 'Янгиарыкский район', 'Yangiariq district'),
(197, 13, 'Yangibozor tumani', 'Янгибозор тумани', 'Янгибазарский район', 'Yangibozor district'),
(198, 14, 'Bektimer tumani', 'Бектимер тумани', 'Бектемирский район', 'Bektemir district'),
(199, 14, 'Mirzo Ulug\'bek tumani', 'Мирзо-Улугбекский район', 'Мирзо-Улугбекский район', 'Mirzo Ulugbek district'),
(200, 14, 'Mirobod tumani', 'Миробод тумани', 'Мирабадский район', 'Mirobod district'),
(201, 14, 'Olmazor tumani', 'Олмазор тумани', 'Алмазарский район', 'Olmazor district'),
(202, 14, 'Sirg\'ali tumani', 'Сиргали тумани', 'Сергелийский район', 'Sirdaryo district'),
(203, 14, 'Uchtepa tumani', 'Учтепа тумани', 'Учтепинский район', 'Uchtepa district'),
(204, 14, 'Yashnobod tumani', 'Яшнобод тумани', 'Яшнободский район', 'Yashnobod district'),
(205, 14, 'Chilonzor tumani', 'Чилонзор тумани', 'Чиланзарский район', 'Chilonzor district'),
(206, 14, 'Shayxontohur tumani', 'Шайхонтоҳур тумани', 'Шайхантахурский район', 'Shayxontohur district'),
(207, 14, 'Yunusobod tumani', 'Юнусобод тумани', 'Юнусабадский район', 'Yunusobod district'),
(208, 14, 'Yakkasaroy tumani', 'Яккасарой тумани', 'Яккасарайский район', 'Yakkasaroy district'),
(209, 1, 'Taxiatosh shahri', 'Тахиатош шаҳри', 'Тахиаташский район', 'Taxiatosh city'),
(210, 2, 'Asaka shahri', 'Асака шаҳри', 'Асакинский район', 'Asaka city'),
(211, 9, 'Bandixon tumani', 'Бандихон тумани', 'Бандиханский район', 'Bandixon district'),
(212, 11, 'Ohangaron shahri', 'Оҳангарон шаҳри', 'город Ахангаранский', 'Ohangaron city'),
(213, 11, 'Yangiyo‘l shahri', 'Янгийўл шаҳри', 'город Янгиюль', 'Yangiyo‘l city'),
(215, 11, 'Toshkent tumani', 'Тошкент тумани', 'Ташкентский район', 'Toshkent district'),
(216, 13, 'Xiva shahri', 'Хива шаҳри\r\n\r\nХива шаҳри\r\n\r\nХива шаҳри', 'город Хива', 'Khiva city'),
(217, 13, 'Do\'stlik shahri', 'Дўстлик шаҳри\r\nДўстлик шаҳри', 'город Дўстлик\r\nДўстлик', 'Do\'stlik city'),
(218, 14, 'Yangihayot tumani', 'Янгиҳаёт тумани', 'Янгихаётский район', 'Yangihayot district'),
(219, 13, 'Tuproqqala tumani', 'Тупроққалъа тумани', 'Тироккальский район', 'Tuproqqala district'),
(220, 7, 'Davlatobod tumani', 'Давлатобод тумани', 'Давлатабадский район ', 'Davlatobod district'),
(221, 6, 'G‘ozg‘on shahar', 'Ғозғон шаҳар', 'Ғозғон Ғозғон', 'Ghazgan city'),
(222, 1, 'Bo‘zatov tumani', 'Бўзатов тумани', 'Бозатовский район', 'Bozatov district'),
(223, 9, 'Bandixon tumani', 'Бандихон тумани', 'Бандиксонский район', 'Bandikhan district'),
(224, 5, 'Shahrisabz shahar', 'Шаҳрисабз шаҳар', 'Город Шахрисабз', 'Shahrisabz city');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
