DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  id smallint NOT NULL,
  cdate datetime DEFAULT NULL,
  status varchar(8) DEFAULT NULL,
  positions text DEFAULT NULL,
  comments text DEFAULT NULL,
  user_id integer DEFAULT NULL,

  CONSTRAINT orders_id PRIMARY KEY(id)
);

CREATE INDEX orders_user_id ON orders
  USING btree (user_id);

