CREATE TABLE force.dbo.Orders (
	Id varchar(36) NOT NULL,
	User_Id varchar(36) NOT NULL,
	Client_Id varchar(36) NOT NULL,
	Product_Id varchar(36) NOT NULL,
	Product_Quant int NOT NULL,
	Order_Status varchar(20) NOT NULL,
	Product_Price float NULL
);
