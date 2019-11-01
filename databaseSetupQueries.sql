 create table Cart (orderId int auto_increment primary key, quantity int not null, permissionLevel varchar(1) not null, orderStatus varchar(1) not null, cost decimal(10,2) not null);

 create table Individual (individualId int auto_increment unique, username varchar(20) not null primary key, email varchar(40) not null unique, password varchar(20) not null, premissionLevel varchar(1) not null);

 create table Product (productId int not null primary key, name varchar (20) not null, keywords varchar(50), productStatus varchar(1), cost decimal(10,2) not null, image blob);

 create table Transaction (transactionId int not null, OrderId int not null, Username varchar(20) not null, ProductId int not null);

 alter table Transaction add foreign key (OrderId) references Cart(orderId);

 alter table Transaction add foreign key (ProductId) references Product(ProductId);

 alter table Transaction add foreign key (Username) references Individual(username);
