-- Cria tabela Users
CREATE TABLE force.dbo.Users (
	Id uniqueidentifier NOT NULL,
	Name varchar(20) NOT NULL,
	Email varchar(100) NOT NULL,
	Password varchar(100) NOT NULL,
	CompanyName varchar(100) NOT NULL
);

