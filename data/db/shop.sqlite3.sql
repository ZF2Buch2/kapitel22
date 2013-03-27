PRAGMA foreign_keys = OFF;
BEGIN TRANSACTION;
DROP TABLE orders;
CREATE TABLE orders (id integer primary key, cdate datetime, status varchar(8), positions text, comments text, user_id integer, FOREIGN KEY(user_id) REFERENCES users(id));
CREATE INDEX orders_user_id on orders(user_id);
COMMIT;
PRAGMA foreign_keys = ON;
