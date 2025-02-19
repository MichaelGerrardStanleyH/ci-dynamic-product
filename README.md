## CodeIgniter 4 - Product Management Application

### Config database

- database.default.hostname = localhost
- database.default.database = ci4
- database.default.username = root
- database.default.password = 12345
- database.default.DBDriver = MySQLi
- database.default.DBPrefix =
- database.default.port = 3306

jika ingin menggunakan konfigurasi sendiri bisa diubah pada file .env

### Config redis

- redis.default.host = 127.0.0.1
- redis.default.port = 6379
- redis.default.password =
- redis.default.database = 0

jika ingin menggunakan konfigurasi sendiri bisa diubah pada file .env

### SQL DDL Query

CREATE TABLE static_product(
product_id int AUTO_INCREMENT,
property_name varchar(255),
property_value varchar(255),
PRIMARY KEY(product_id)
);

CREATE TABLE dynamic_product(
product_id int AUTO_INCREMENT,
property_name varchar(255),
property_value varchar(255),
static_product_id int,
PRIMARY KEY(product_id)
);

ALTER TABLE dynamic_product
ADD CONSTRAINT fk_static_product
FOREIGN KEY(static_product_id)
REFERENCES static_product(product_id) ON DELETE CASCADE;

### Cara menjalankan aplikasi

- Jalankan service backendnya dulu dengan mengetikan <span style="background-color:grey;color:black">php spark serve</span>
- Jalankan frontendnya yang ada di https://github.com/MichaelGerrardStanleyH/react-dynamic-product-fe dengan mengetikan <span style="background-color:grey;color:black">npm run dev</span>

### Feature

- Get all product
- Add product
- Delete product
- Get all dynamic product by product
- Add dynamic product
- Edit dynamic product
- Delete Dynamic product

### Cara menambahkan dynamic property pada product dengan API

1. Buat satu produk dengan endpoint <span style="background-color:grey;color:white">http://localhost:8080/products</span> dengan method <span style="color:Yellow">POST</span>, contoh: membuat produk dengan nama Laptop

```json
{
  "property_name": "name",
  "property_value": "Laptop"
}
```

2. Buat property dinamis produk laptop dengan endpoint <span style="background-color:grey;color:white">http://localhost:8080/dynamic-products</span> dengan method <span style="color:Yellow">POST</span>, contoh: membuat dynamic property price dengan value 12000000 dan serta id dari product laptop(3)

```json
{
  "property_name": "price",
  "property_value": "12000000",
  "static_product_id": 3
}
```

3.Jika ingin mengakses dynamic property product bisa dengan memanggil product laptop melalui endpoint <span style="background-color:grey;color:white">http://localhost:8080/products/3</span> dengan method <span style="color:Yellow">GET</span> atau dengan memanggil langsung dynamic product yang ingin ditampilkan dengan endpoint <span style="background-color:grey;color:white">http://localhost:8080/dynamic-products/4</span> dengan method <span style="color:Yellow">GET</span>

### Git Command

- git clone: mengunggah project backend ke local
- git pull: mengambil perubahan berdasarkan commmitan terbaru

### Composer & Codeigniter Command

- composer install: install dependency-dependency yang dibutuhkan
- php spark serve: menjalankan aplikasi CodeIgniter4
- jalankan API dengan base_url http://localhost:8080

### Postman Collection
https://drive.google.com/drive/folders/1JqB53KFr0MmNZ5R5f9jHFs4qpTKHsfdC?usp=sharing
