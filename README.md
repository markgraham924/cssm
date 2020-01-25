`CREATE TABLE 'deliveries' (
  'deliveryID' int PRIMARY KEY AUTO_INCREMENT,
  'recieved' timestamp,
  'numberSingles' int,
  'deliveryCode' varchar(255)
);

CREATE TABLE 'products' (
  'productID' int PRIMARY KEY AUTO_INCREMENT,
  'productUPC' varchar(255),
  'productName' varchar(255),
  'productPrice' varchar(255)
);

CREATE TABLE 'stockFile' (
  'productID' int,
  'stockPosition' float,
  'statusID' int
);

CREATE TABLE 'orders' (
  'orderID' int PRIMARY KEY AUTO_INCREMENT,
  'customerID' int,
  'paymentID' int
);

CREATE TABLE 'orders_item' (
  'orderID' int,
  'productID' int
);

CREATE TABLE 'payments' (
  'paymentID' int,
  'details' varchar(255)
);

CREATE TABLE 'customers' (
  'customerID' int PRIMARY KEY AUTO_INCREMENT,
  'customerName' varchar(255),
  'customerAddress' varchar(255)
);

CREATE TABLE 'salesFile' (
  'productID' int,
  'salesPosition' float
);

CREATE TABLE 'deliveries_item' (
  'deliveryID' int,
  'productID' int,
  'trayCode' varchar(255)
);

CREATE TABLE 'statusTypes' (
  'statusID' int PRIMARY KEY AUTO_INCREMENT,
  'statusName' varchar(255),
  'statusColour' varchar(255)
);

ALTER TABLE 'orders' ADD FOREIGN KEY ('customerID') REFERENCES 'customers' ('customerID');

ALTER TABLE 'orders' ADD FOREIGN KEY ('paymentID') REFERENCES 'payments' ('paymentID');

ALTER TABLE 'orders_item' ADD FOREIGN KEY ('orderID') REFERENCES 'orders' ('orderID');

ALTER TABLE 'orders_item' ADD FOREIGN KEY ('productID') REFERENCES 'products' ('productID');

ALTER TABLE 'salesFile' ADD FOREIGN KEY ('productID') REFERENCES 'products' ('productID');

ALTER TABLE 'deliveries_item' ADD FOREIGN KEY ('deliveryID') REFERENCES 'deliveries' ('deliveryID');

ALTER TABLE 'deliveries_item' ADD FOREIGN KEY ('productID') REFERENCES 'products' ('productID');

ALTER TABLE 'stockFile' ADD FOREIGN KEY ('productID') REFERENCES 'products' ('productID');

ALTER TABLE 'stockFile' ADD FOREIGN KEY ('statusID') REFERENCES 'statusTypes' ('statusID');
`
