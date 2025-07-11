drop database if exists disertatie_placinta;
create database disertatie_placinta
default character set utf8mb4
default collate utf8mb4_general_ci;

use disertatie_placinta;

drop table if exists admin;
create table admin (
id bigint auto_increment primary key,
nume_user varchar(40) not null unique,
email varchar(40) not null unique,
hash_parola varchar(255) not null,
nr_tel char(10) not null unique
);

insert into admin (id, nume_user, email, hash_parola, nr_tel) values
(1, 'andrei.placinta', 'andrei.placinta@gmail.com', '$2y$10$gj98qlMixQrAXr66Z0.kpuaoeBtJYoiN6.Z76gqGuN3dEU1Xii.Om', '0000000001'),
(2, 'admin', 'admin@gmail.com', '$2y$10$j.AuL2tcpbnhgjKWU7CS3..un18mhE2TlR9No92GxyUeLymzVoGCe', '0000000002'),
(3, 'user', 'user@gmail.com', '$2y$10$XSadg2we5zix/3pq9rIkV.y45EGCsUDpIrkT1x0EM6s3Eifqb2PDi', '0000000003'),
(4, 'test', 'test@gmail.com', '$2y$10$Yhk8seLbw0vZmI8bIPlBuOebUyQVLZknrEss.j7gegw1E1Rt3PwxO', '0000000004');

drop table if exists optiune;
create table optiune (
id bigint auto_increment primary key,
titlu text not null,
email varchar(40) not null,
nr_tel char(10) not null,
poza text not null,
despre text not null
);

insert into optiune (id, titlu, email, nr_tel, poza, despre) values
(1, 'Rezervari', 'exemplu@gmail.com', '1233214567', 'upload.jpg', '&lt;h3 style=&quot;font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; line-height: 1.3em; color: rgb(86, 86, 86); margin-bottom: 10px; font-size: 24px; text-align: center;&quot;&gt;Planifica-ti calatoria, rezerva locul, ajungi la destinatie.&lt;/h3&gt;&lt;p style=&quot;margin-bottom: 10px; color: rgb(72, 72, 72); font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; font-size: 16px; text-align: center;&quot;&gt;O platforma moderna de rezervare online a locurilor in autobuz iti permite sa cumperi bilete rapid si simplu, direct de pe internet. Dupa confirmarea rezervarii, primesti un mesaj cu toate detaliile legate de calatorie.&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 10px; color: rgb(72, 72, 72); font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; font-size: 16px; text-align: center;&quot;&gt;Beneficiile utilizarii unui sistem de rezervare eficient includ: planificarea din timp a calatoriilor, economisirea timpului, evitarea cozilor, localizarea usoara a punctului de imbarcare si o experienta de calatorie mai confortabila si relaxanta.&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

drop table if exists oras;
create table oras (
    id bigint auto_increment primary key,
    denumire varchar(40) not null
);

insert into oras (id, denumire) values
(1, 'Timisoara, TM'),
(2, 'Bucuresti, B'),
(3, 'Cluj Napoca, CJ'),
(4, 'Iasi, IS');

drop table if exists cursa;
create table cursa (
id bigint auto_increment primary key,
origine_id bigint,
destinatie_id bigint,
program datetime not null,
locuri_disp tinyint not null,
pret decimal(6,2) not null,
constraint fk_origine_id foreign key (origine_id) references oras(id) on delete set null on update cascade,
constraint fk_destinatie_id foreign key (destinatie_id) references oras(id) on delete set null on update cascade
);

insert into cursa (id, origine_id, destinatie_id, program, locuri_disp, pret) values
(1, 1, 2, '2025-05-10 10:00:00', 40, 200),
(2, 1, 3, '2025-05-11 11:00:00', 35, 150),
(3, 1, 4, '2025-05-12 12:00:00', 30, 250),
(4, 2, 1, '2025-05-13 13:00:00', 25, 200),
(5, 2, 3, '2025-05-14 14:00:00', 20, 150),
(6, 2, 4, '2025-05-15 15:00:00', 15, 100),
(7, 3, 1, '2025-05-16 16:00:00', 10, 150),
(8, 3, 2, '2025-05-17 17:00:00', 5, 150),
(9, 3, 4, '2025-05-18 18:00:00', 45, 150),
(10, 4, 1, '2025-05-19 19:00:00', 50, 250),
(11, 4, 2, '2025-05-20 20:00:00', 55, 100),
(12, 4, 3, '2025-05-21 21:00:00', 60, 150);

drop table if exists rezervare;
create table rezervare (
id bigint auto_increment primary key,
id_cursa bigint,
nume varchar(40) not null,
telefon char(10) not null,
email varchar(40) not null,
stare enum('in progres', 'confirmata', 'anulata') default 'in progres',
foreign key (id_cursa) references cursa(id)
);

insert into rezervare (id, id_cursa, nume, telefon, email, stare) values
(1, 1, 'Andrei Placinta', '0000000010', 'andreiplacinta@gmail.com', 'in progres'),
(2, 1, 'Ion Popescu', '0000000020', 'ionpopescu@gmail.com', 'in progres'),
(3, 3, 'Bogdan Ioan', '0000000030', 'bogdanioan@gmail.com', 'confirmata'),
(4, 4, 'Maria Elena', '0000000040', 'mariaelena@gmail.com', 'confirmata'),
(5, 5, 'Florin-Radu Gabriel', '0000000050', 'florin.radugabriel@gmail.com', 'anulata');

drop table if exists delete_tokens;
create table delete_tokens (
id bigint auto_increment primary key,
user_id bigint,
token varchar(64) not null,
created_at datetime not null
);

drop table if exists save_tokens;
create table save_tokens (
id bigint auto_increment primary key,
user_id bigint,
token varchar(64) not null,
data text not null,
created_at datetime not null
);