create type session_status as enum ('valid', 'invalidated');

create table users
(
    user_id               uuid    default gen_random_uuid() not null
        constraint users_pk
            primary key,
    username              varchar(20)                       not null,
    password              char(60)                          not null,
    first_name            varchar(50)                       not null,
    last_name             varchar(50)                       not null,
    is_admin              boolean default false             not null,
    account_creation_time date    default now()             not null
);

create table authors
(
    author_id uuid default gen_random_uuid() not null
        constraint authors_pk
            primary key,
    name      varchar(50)                    not null,
    last_name varchar(50)                    not null
);

create table category
(
    category_id uuid default gen_random_uuid() not null
        constraint category_pk
            primary key,
    name        varchar(50)                    not null
);

create table books
(
    book_id  uuid    default gen_random_uuid() not null
        constraint books_pk
            primary key,
    name     varchar(50)                       not null,
    author   uuid                              not null
        constraint author_fk
            references authors
            on update cascade on delete cascade,
    category uuid                              not null
        constraint category_fk
            references category
            on update cascade on delete cascade,
    units    integer default 0                 not null
);

create table borrows
(
    borrow_id          uuid default gen_random_uuid() not null
        constraint borrows_pk
            primary key,
    user_id            uuid                           not null
        constraint users_fk
            references users,
    book_id            uuid                           not null
        constraint books_fk
            references books,
    borrow_date        date                           not null,
    return_date        date                           not null,
    actual_return_date date
);

create table sessions
(
    session_id    uuid           default gen_random_uuid()       not null
        constraint sessions_pk
            primary key,
    user_id       uuid                                           not null
        constraint user_fk
            references users
            on update cascade on delete cascade,
    creation_time timestamp      default now()                   not null,
    status        session_status default 'valid'::session_status not null
);