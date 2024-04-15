drop table post_tags;
insert into users (name, role, email, password) values 
('Tim', 2, 'tim_test.ya.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
update posts set user_id=2 where id=1;
update users set role=1 where id=1;