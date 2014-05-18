use diploma_development;
INSERT INTO `groupuser` (`id`, `name`, `arm`, `composite`, `message`) VALUES
(19, 'verification', 'Факультет', 0, '');

INSERT INTO `user` (`id`, `name`, `pass`, `id_dep`, `id_group`, `email`, `flag_hide`, `lastlogin`, `lastact`, `ipmask`) VALUES
(201, 'faq', 'e80eded141e1295d694cd35cf2b8f675', 141847680, 2, '', 0, '2013-07-08 10:50:41', 'log in', ''),
(202, 'ver_admin', 'e80eded141e1295d694cd35cf2b8f675', 141847680, 19, '', 0, '2013-07-08 10:50:41', 'log in', ''),
(203, 'ver_user', 'e80eded141e1295d694cd35cf2b8f675', 141847680, 19, '', 0, '2013-07-08 10:50:41', 'log in', '');

INSERT INTO rating_user_permissions (id, permissions, role) VALUES
(202, '', 'admin');

INSERT INTO rating_seasons(id, from_date, to_date) VALUES
(1, '2013-01-01', '2013-12-31'),
(2, '2014-01-01', '2014-12-31');