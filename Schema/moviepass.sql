create database if not exists moviepass;

use moviepass;

create table if not exists cinemas (
    cinemaID int AUTO_INCREMENT,
    name varchar(50) not null,
    address varchar(50) not null unique,
    isActive boolean not null default true,

    constraint pkCinemaID primary key (cinemaID)

) ENGINE = InnoDB;

create table if not exists rooms (
    roomID int AUTO_INCREMENT,
    cinemaID int not null,
    name varchar(50) not null,
    capacity int UNSIGNED not null,
    ticketValue int UNSIGNED not null,
    isActive boolean not null default true,

    constraint pkRoomID primary key (roomID),
    constraint fkCinemaID foreign key (cinemaID) references cinemas (cinemaID)

) ENGINE = InnoDB;

create table if not exists movies (
    movieID int AUTO_INCREMENT,
    title varchar(50) not null,
    overview varchar(300),
    dateRelease date,
    length int,
    posterPath varchar(60),
    trailerPath varchar(60),
    language varchar(10),
    voteAverage float,
    isActive boolean not null default true,

    constraint pkMovieID primary key (movieID)

) ENGINE = InnoDB;

create table if not exists shows (
    showID int AUTO_INCREMENT,
    roomID int not null,
    movieID int not null,
    showDate date not null,
    showTime time not null,
    isActive boolean not null default true,

    constraint pkShowID primary key (showID),
    constraint fkRoomID foreign key (roomID) references rooms (roomID),
    constraint fkShowMovieID foreign key (movieID) references movies (movieID)

) ENGINE = InnoDB;

create table if not exists users (
    userID int AUTO_INCREMENT,
    userName varchar(50) not null,
    password varchar(50) not null,
    firstName varchar(50) not null,
    lastName varchar(50) not null,
    email varchar(50) not null,
    role smallInt not null,

    constraint pkUserID primary key (userID)

) ENGINE = InnoDB;

create table if not exists genres (
    genreID int AUTO_INCREMENT,
    name varchar(20),

    constraint pkGenreID primary key (genreID)

) ENGINE = InnoDB;

create table if not exists genresXMovies (
    genreXMovieID int AUTO_INCREMENT,
    movieID int not null,
    genreID int not null,

    constraint pkGenreXMovie primary key (genreXMovieID),
    constraint fkGenreXMovieMovieID foreign key (movieID) references movies (movieID),
    constraint fkGenreXMovieGenreID foreign key (genreID) references genres (genreID)

) ENGINE = InnoDB;

create table if not exists purchases (
    purchaseID int AUTO_INCREMENT,
    userID int not null,
    purchaseDate date,
    subTotal float,
    hasDiscount boolean,
    purchaseTotal float,

    constraint pkPurchaseID primary key (purchaseID),
    constraint fkUserID foreign key (userID) references users (userID)

) ENGINE = InnoDB;

create table if not exists tickets (
    ticketID int AUTO_INCREMENT,
    showID int not null,
    purchaseID int not null,
    seatLocation smallInt UNSIGNED,
    qrCodeURL varchar(100),

    constraint pkTicketID primary key (ticketID),
    constraint fkTicketShowID foreign key (showID) references shows (showID),
    constraint fkPurchaseID foreign key (purchaseID) references purchases (purchaseID)

) ENGINE = InnoDB;