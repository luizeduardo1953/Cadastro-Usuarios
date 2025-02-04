drop database IF EXISTS cadastro;
create database cadastro;
use cadastro;
create table pessoas(
    codpessoa integer not null AUTO_INCREMENT,
    nome varchar(60),
    telefone varchar(20),
    email varchar(120),
	primary key(codpessoa)
);
