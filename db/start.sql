-- Verifica se o banco de dados já existe e o remove
drop database if exists trocadeideia;

-- Cria o banco de dados
create database trocadeideia;

-- Seleciona o banco de dados recém-criado
use trocadeideia;

-- Verifica se a tabela de usuários já existe e a remove
drop table if exists usuarios;

-- Cria a tabela 'usuarios'
create table usuarios (
    id_usuario int auto_increment unique not null,
    nome_usuario varchar(128) not null,
    apelido varchar(32) not null,
    email text not null,
    senha varchar(32) not null,
    foto mediumblob default null,
    primary key (id_usuario)
);

-- Verifica se a tabela de postagens já existe e a remove
drop table if exists postagens;

-- Cria a tabela 'postagens'
create table postagens (
    id_post int auto_increment unique not null,
    id_usuario int not null,
    conteudo text default null,
    curtidas int default 0,
    primary key (id_post),
    key id_usuario (id_usuario),
    foreign key (id_usuario) references usuarios(id_usuario)
);

-- Verifica se a tabela de solicitacoes_amizade já existe e a remove
drop table if exists solicitacoes_amizade;

-- Cria a tabela 'solicitacoes_amizade'
create table solicitacoes_amizade (
    id_solicitacao int auto_increment unique not null,
    id_usuario_requisitante int not null,
    id_usuario_destinatario int not null,
    status enum('pendente', 'aceita', 'rejeitada') not null default 'pendente',
    data_solicitacao timestamp default current_timestamp,
    primary key (id_solicitacao),
    foreign key (id_usuario_requisitante) references usuarios(id_usuario),
    foreign key (id_usuario_destinatario) references usuarios(id_usuario)
);

-- Verifica se a tabela de amigos já existe e a remove
drop table if exists amigos;

-- Cria a tabela 'amigos'
create table amigos (
    id_usuario1 int not null,
    id_usuario2 int not null,
    data_amizade timestamp default current_timestamp,
    primary key (id_usuario1, id_usuario2),
    foreign key (id_usuario1) references usuarios(id_usuario) on delete cascade,
    foreign key (id_usuario2) references usuarios(id_usuario) on delete cascade
);
