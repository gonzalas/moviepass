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
    movieID int,
    title varchar(50) not null,
    overview varchar(600),
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
    startTime time not null,
    endTime time not null,
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
    isAdmin boolean not null,

    constraint pkUserID primary key (userID)

) ENGINE = InnoDB;

create table if not exists genres (
    genreID int,
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
    showID int not null,
    purchaseDate date,
    subTotal float,
    hasDiscount boolean,
    purchaseTotal float,

    constraint pkPurchaseID primary key (purchaseID),
    constraint fkTicketShowID foreign key (showID) references shows (showID),
    constraint fkUserID foreign key (userID) references users (userID)

) ENGINE = InnoDB;

create table if not exists tickets (
    ticketID int AUTO_INCREMENT,
    purchaseID int not null,
    seatLocation smallInt UNSIGNED, #set according to the amount of tickets sold on the show
    qrCodeURL varchar(100),

    constraint pkTicketID primary key (ticketID),
    constraint fkPurchaseID foreign key (purchaseID) references purchases (purchaseID)

) ENGINE = InnoDB;