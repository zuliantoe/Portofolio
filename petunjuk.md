1. Create database dengan nama portofolio
2. create table users dengan kolom (id,username,password) username adalah unik.
3. create table portofolio_items untuk kolom sesuaikan dengan yang akan dibuat minimal id,title,description,image_url.   

pastikan sudah install mysql di laptop masing2

command untuk create database

```sql
CREATE DATABASE portofolio;
```

command untuk create table users

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);
```

command untuk create table portofolio_items

```sql
CREATE TABLE portofolio_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  image_url VARCHAR(255)
);
```

