create table items (
    id           integer primary key,
    parent_id    integer references items(id),
    name         varchar(100)
);

create table folders (
    id           integer primary key references items(id)
);

create table documents (
    id           integer primary key references items(id)
);

insert into items values (1, null, 'Root');
insert into items values (2, 1, 'Music Theory 101');
insert into items values (3, 2, 'Images');
insert into items values (4, 1, 'Harmonic Ear Training');
insert into items values (5, 4, 'Videos');
insert into items values (6, 2, 'Course Outline');
insert into items values (7, 2, 'Lesson 1');
insert into items values (8, 3, 'logo.jpg');
insert into items values (9, 4, 'Course Outline');
insert into items values (10, 4, 'Lesson 1');
insert into items values (11, 5, 'Intro.mp4');
insert into folders select id from items where id <= 5;
insert into documents select id from items where id > 5;