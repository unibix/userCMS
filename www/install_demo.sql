-- Adminer 4.2.5 SQLite 3 dump

CREATE TABLE "activated_modules" (
  "id" integer NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NULL,
  "type" text NULL,
  "position" text NULL,
  "back_end" integer NULL DEFAULT '0',
  "sort" integer NULL DEFAULT '1',
  "module_id" integer NULL,
  "module_dir" text NULL,
  "params" text NULL,
  "sections" text NULL,
  "date_edit" integer NULL
);


INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (1,	'jQuery (ядро)',	'addon',	'before',	'0',	2,	1,	'jquery',	NULL,	NULL,	1234567890);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (2,	'jQuery (ядро for BackEnd)',	'addon',	'before',	1,	1,	1,	'jquery',	NULL,	NULL,	1234567890);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (7,	'Вкладки',	'addon',	'after',	1,	5,	11,	'tabs',	NULL,	NULL,	123123);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (9,	'Fancy Box',	'addon',	'after',	1,	3,	2,	'fancybox',	'1,2,3,4,5',	NULL,	1366562331);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (10,	'Fancy Box для frontend''a',	'addon',	'after',	'0',	3,	2,	'fancybox',	'1,2,3,4,5',	NULL,	1366562646);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (18,	'Редактор кода Codemirror',	'addon',	'after',	1,	2,	19,	'codemirror',	'',	'',	1382107589);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (19,	'Главное меню админки',	'block',	'main_menu',	1,	4,	14,	'menu',	's:1:"2";',	NULL,	1380884810);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (29,	'Главное меню сайта',	'block',	'top_menu',	'0',	5,	14,	'menu',	's:1:"4";',	'',	1481295097);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (40,	'301 редирект',	'addon',	'before',	'0',	1,	25,	'redirect_301',	'/test|/kontakty',	'',	1384346865);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (41,	'Текстовый редактор jodit',	'addon',	'after',	1,	6,	28,	'jodit',	'',	'',	1537785328);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (42,	'Форма обратной связи',	'plugin',	'feedback',	'0',	7,	24,	'feedback',	'YTo2OntzOjY6ImZpZWxkcyI7YTo0OntpOjA7YTo1OntzOjQ6InR5cGUiO3M6NDoidGV4dCI7czo1OiJsYWJlbCI7czoxNToi0JLQsNGI0LUg0LjQvNGPIjtzOjg6InJlcXVpcmVkIjtzOjE6IjAiO3M6MTA6InZhbGlkYXRpb24iO3M6OToibm90X2VtcHR5IjtzOjEzOiJlcnJvcl9tZXNzYWdlIjtzOjA6IiI7fWk6MTthOjU6e3M6NDoidHlwZSI7czo0OiJ0ZXh0IjtzOjU6ImxhYmVsIjtzOjIxOiLQktCw0Ygg0YLQtdC70LXRhNC+0L0iO3M6ODoicmVxdWlyZWQiO3M6MToiMSI7czoxMDoidmFsaWRhdGlvbiI7czo1OiJwaG9uZSI7czoxMzoiZXJyb3JfbWVzc2FnZSI7czo1NToi0JLQstC10LTQuNGC0LUg0LLQtdGA0L3Ri9C5INC90L7QvNC10YAg0YLQtdC70LXRhNC+0L3QsCI7fWk6MjthOjU6e3M6NDoidHlwZSI7czo4OiJ0ZXh0YXJlYSI7czo1OiJsYWJlbCI7czoyNzoi0JLQsNGI0LUg0YHQvtC+0LHRidC10L3QuNC1IjtzOjg6InJlcXVpcmVkIjtzOjE6IjEiO3M6MTA6InZhbGlkYXRpb24iO3M6OToibm90X2VtcHR5IjtzOjEzOiJlcnJvcl9tZXNzYWdlIjtzOjA6IiI7fWk6MzthOjI6e3M6NDoidHlwZSI7czo2OiJzdWJtaXQiO3M6NToibGFiZWwiO3M6MTg6ItCe0YLQv9GA0LDQstC40YLRjCI7fX1zOjc6Im1haWxfdG8iO3M6MTI6ImluZm9Ac2l0ZS5ydSI7czoxMjoibWFpbF9zdWJqZWN0IjtzOjU3OiLQodC+0L7QsdGJ0LXQvdC40LUg0YHQviDRgdGC0YDQsNC90LjRhtGLINCa0L7QvdGC0LDQutGC0YsiO3M6OToibWFpbF9mcm9tIjtzOjE1OiJub3JlcGx5QHNpdGUucnUiO3M6MTQ6Im1haWxfdGV4dF9mcm9tIjtzOjEwOiLQoNC+0LHQvtGCIjtzOjE3OiJtYWlsX3RleHRfc3VjY2VzcyI7czo0ODoi0JLQsNGI0LUg0YHQvtC+0LHRidC10L3QuNC1INC+0YLQv9GA0LDQstC70LXQvdC+Ijt9',	'',	1514029556);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (45,  'Слайдер CUBE', 'block',  'slider', '0',  7,  31, 'cube_slider',  'a:5:{s:12:"aspect_ratio";d:2.9;s:5:"speed";i:1000;s:9:"frequency";i:5000;s:10:"has_shadow";b:0;s:6:"slides";a:3:{i:0;a:4:{s:5:"image";s:34:"/uploads/modules/cube_slider/1.jpg";s:4:"text";s:49:"Тестовый текст на картинке";s:8:"btn_text";s:45:"Тестовый текст на кнопке";s:4:"href";s:0:"";}i:1;a:4:{s:5:"image";s:34:"/uploads/modules/cube_slider/2.jpg";s:4:"text";s:49:"Тестовый текст на картинке";s:8:"btn_text";s:45:"Тестовый текст на кнопке";s:4:"href";s:0:"";}i:2;a:4:{s:5:"image";s:34:"/uploads/modules/cube_slider/3.jpg";s:4:"text";s:49:"Тестовый текст на картинке";s:8:"btn_text";s:45:"Тестовый текст на кнопке";s:4:"href";s:0:"";}}}',  '', 1481295676);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (46,	'Боковое меню',	'block',	'aside',	'0',	4,	14,	'menu',	's:1:"7";',	'',	1481295416);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (47,	'Написать директору',	'plugin',	'feedback',	'0',	8,	24,	'feedback',	'YTo2OntzOjY6ImZpZWxkcyI7YTo2OntpOjA7YTo1OntzOjQ6InR5cGUiO3M6NDoidGV4dCI7czo1OiJsYWJlbCI7czoxNToi0JLQsNGI0LUg0LjQvNGPIjtzOjg6InJlcXVpcmVkIjtzOjE6IjEiO3M6MTA6InZhbGlkYXRpb24iO3M6OToibm90X2VtcHR5IjtzOjEzOiJlcnJvcl9tZXNzYWdlIjtzOjA6IiI7fWk6MTthOjU6e3M6NDoidHlwZSI7czo0OiJ0ZXh0IjtzOjU6ImxhYmVsIjtzOjIxOiLQktCw0Ygg0YLQtdC70LXRhNC+0L0iO3M6ODoicmVxdWlyZWQiO3M6MToiMSI7czoxMDoidmFsaWRhdGlvbiI7czo1OiJwaG9uZSI7czoxMzoiZXJyb3JfbWVzc2FnZSI7czo1NToi0JLQstC10LTQuNGC0LUg0LLQtdGA0L3Ri9C5INC90L7QvNC10YAg0YLQtdC70LXRhNC+0L3QsCI7fWk6MjthOjU6e3M6NDoidHlwZSI7czo0OiJ0ZXh0IjtzOjU6ImxhYmVsIjtzOjE3OiLQktCw0Ygg0LXQvNC10LnQuyI7czo4OiJyZXF1aXJlZCI7czoxOiIxIjtzOjEwOiJ2YWxpZGF0aW9uIjtzOjU6ImVtYWlsIjtzOjEzOiJlcnJvcl9tZXNzYWdlIjtzOjMzOiLQktCy0LXQtNC40YLQtSDQstC10YDQvdGL0LkgZW1haWwiO31pOjM7YTozOntzOjQ6InR5cGUiO3M6Njoic2VsZWN0IjtzOjU6ImxhYmVsIjtzOjQ5OiLQotC10LzQsCDQvtCx0YDQsNGJ0LXQvdC40Y8g0Log0LTQuNGA0LXQutGC0L7RgNGDIjtzOjExOiJvcHRpb25fbGlzdCI7czoxNDg6ItCg0LXQutC70LDQvNCwDQrQoNCw0LfQstC40YLQuNC1DQrQn9Cw0YDRgtC90LXRgNGB0YLQstC+INC40LvQuCDRgdC+0YLRgNGD0LTQvdC40YfQtdGB0YLQstC+DQrQltCw0LvQvtCx0LAg0L3QsCDRgdC+0YLRgNGD0LTQvdC40LrQvtCyDQrQlNGA0YPQs9C+0LUiO31pOjQ7YTo1OntzOjQ6InR5cGUiO3M6ODoidGV4dGFyZWEiO3M6NToibGFiZWwiO3M6Mjc6ItCS0LDRiNC1INGB0L7QvtCx0YnQtdC90LjQtSI7czo4OiJyZXF1aXJlZCI7czoxOiIxIjtzOjEwOiJ2YWxpZGF0aW9uIjtzOjk6Im5vdF9lbXB0eSI7czoxMzoiZXJyb3JfbWVzc2FnZSI7czowOiIiO31pOjU7YToyOntzOjQ6InR5cGUiO3M6Njoic3VibWl0IjtzOjU6ImxhYmVsIjtzOjE4OiLQntGC0L/RgNCw0LLQuNGC0YwiO319czo3OiJtYWlsX3RvIjtzOjEyOiJpbmZvQHNpdGUucnUiO3M6MTI6Im1haWxfc3ViamVjdCI7czo0NToi0KHQvtC+0LHRidC10L3QuNC1INGBINCy0LDRiNC10LPQviDRgdCw0LnRgtCwIjtzOjk6Im1haWxfZnJvbSI7czoxNToibm9yZXBseUBzaXRlLnJ1IjtzOjE0OiJtYWlsX3RleHRfZnJvbSI7czoxMjoi0JfQsNGP0LLQutCwIjtzOjE3OiJtYWlsX3RleHRfc3VjY2VzcyI7czo0ODoi0JLQsNGI0LUg0YHQvtC+0LHRidC10L3QuNC1INC+0YLQv9GA0LDQstC70LXQvdC+Ijt9',	'',	1514029387);

CREATE TABLE "gallery_categories" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL,
  "text" text NOT NULL,
  "preview" text NOT NULL,
  "image" text NOT NULL,
  "url" text NOT NULL,
  "title" text NOT NULL,
  "keywords" text NOT NULL,
  "description" text NOT NULL,
  "dir" text NOT NULL
, "sub" text NOT NULL DEFAULT '0');


INSERT INTO "gallery_categories" ("id", "name", "text", "preview", "image", "url", "title", "keywords", "description", "dir", "sub") VALUES ('1', 'Первая', '', '', '', 'pervaya', 'Первая', 'Первая', 'Первая', 'pervaya', '0');
INSERT INTO "gallery_categories" ("id", "name", "text", "preview", "image", "url", "title", "keywords", "description", "dir", "sub") VALUES ('2', 'Вторая', '', '', 'wmgzw9nejm.jpg', 'vtoraya', 'Вторая', 'Вторая', 'Вторая', 'vtoraya', '0');


CREATE TABLE "gallery_items" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "category_id" integer NOT NULL,
  "image" text NOT NULL,
  "text" text NOT NULL,
  "sort" integer NULL DEFAULT '1',
  "date_add" integer NOT NULL,
  FOREIGN KEY ("category_id") REFERENCES "gallery_categories" ("id") ON DELETE CASCADE ON UPDATE NO ACTION
);

INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('1', '1', '1.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('2', '1', '2.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('3', '1', '3.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('4', '1', '4.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('5', '1', '5.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('6', '1', '6.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('7', '1', '7.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('8', '1', '8.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('9', '1', '9.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('10', '1', '10.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('11', '1', '11.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('12', '1', '12.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('13', '1', '13.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('14', '1', '14.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('15', '1', '15.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('16', '1', '16.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('17', '1', '17.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('18', '1', '18.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('19', '1', '19.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('20', '1', '20.jpg', '', '1', 1575900551);

INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('21', '2', '1.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('22', '2', '2.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('23', '2', '3.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('24', '2', '4.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('25', '2', '5.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('26', '2', '6.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('27', '2', '7.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('28', '2', '8.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('29', '2', '9.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('30', '2', '10.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('31', '2', '11.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('32', '2', '12.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('33', '2', '13.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('34', '2', '14.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('35', '2', '15.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('36', '2', '16.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('37', '2', '17.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('38', '2', '18.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('39', '2', '19.jpg', '', '1', 1575900551);
INSERT INTO "gallery_items" ("id", "category_id", "image", "text", "sort", "date_add") VALUES ('40', '2', '20.jpg', '', '1', 1575900551);


CREATE TABLE "installed_modules" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL,
  "type" text NOT NULL,
  "dir" text NULL,
  "version" text NOT NULL,
  "date_add" integer NULL
, "description" text NULL);

INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (1,  'jQuery',   'addon',    'jquery',   '1.2.6',    1382108205, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (2,  'FancyBox', 'addon',    'fancybox', '2.07', 1382108205, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (11, 'Tabs', 'addon',    'tabs', '1.0',  1382108205, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (13, 'Блок HTML кода',   'block',    'custom_html',  '1.0',  1382108205, 'Модуль позволяет добавлять на станицу пользовательский html код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (14, 'Block menu',   'block',    'menu', '0.1',  1382108205, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (19, 'Codemirror',   'addon',    'codemirror',   '0.9',  1380269571, 'Codemirror is a versatile text editor implemented in JavaScript for the browser. It is specialized for editing code, and comes with a number of language modes and addons that implement more advanced editing functionaly.');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (24, 'Форма обратной связи', 'plugin',   'feedback', '2.0',  1390771119, 'Стандартная форма обратной связи');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (25, '301 редирект', 'addon',    'redirect_301', '1.0',  1384346742, '
Пример: 
/old_url.html|/ne_url.html
/catalog|/katalog
/contacts.html|/kontakty.html');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (28, 'Текстовый редактор jodit',  'addon',    'jodit', '3.1.95',  1537785328, '');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (30, 'Анонс новостей',   'block',    'news_announce',    '2.0',  1480488062, 'Анонс новостей');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (31, 'Слайдер CUBE', 'block',    'cube_slider',  '1.4',  1481290914, 'Слайдер в виде вращающегося куба.');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (32, 'Блок HTML кода',   'plugin',    'custom_html',  '1.0',  1533821211, 'Модуль позволяет добавлять на станицу пользовательский html код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (33, 'Блок выполняемого кода',   'plugin',    'custom_script',  '1.0',  1533821211, 'Модуль позволяет добавлять на станицу пользовательский выполняемый код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (34, 'Блок выполняемого кода',   'block',    'custom_script',  '1.0',  1533821211, 'Модуль позволяет добавлять на станицу пользовательский выполняемый код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (35, 'Галерея BOX', 'plugin', 'gallery_box', '1.0', 1533821211, 'Плагин Галерея BOX');


CREATE TABLE "main" (
  "id" integer NULL PRIMARY KEY AUTOINCREMENT,
  "parent_id" integer NULL DEFAULT '0',
  "name" text NOT NULL,
  "title" text NOT NULL,
  "keywords" text NOT NULL,
  "description" text NOT NULL,
  "component" text NOT NULL,
  "url" text NULL,
  "view" text NULL,
  "theme_view" text NULL,
  "date_add" integer NULL,
  "date_edit" integer NULL
);

INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (1,    '0',    'Главная страница', 'Сайт', 'Ключевые слова',   'Описание главной страницы',    'pages',    '/',    'no_breadcrumbs',   'index',    12312312,   1481523175);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (3,    '0',    'Галерея',  'Галерея',  'Галерея',  'Галерея',  'gallery',  'gallery',  NULL,   NULL,   23423422,   1481523482);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (43,   '0',    'Контакты', 'Контакты', 'Контакты', 'Контакты', 'pages',    'contacts', 'children_menu',    'index',    1380887801, 1481556353);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (49,   '0',    'Карта сайта',  'Карта сайта',  'Карта сайта',  'Карта сайта',  'sitemap',  'map',  NULL,   NULL,   1381932241, 1381932241);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (57,   '0',    'Карта сайта xml',  'Карта сайта xml',  'Карта сайта xml',  'Карта сайта xml',  'sitemap_xml',  'sitemap2.xml', NULL,   NULL,   1384344538, 1384344538);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (58,   '0',    'Новости',  'Новости',  'Новости',  'Новости',  'news', 'news', NULL,   NULL,   1480488322, 1480488322);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (59,   '0',    'Типографика в UserCMS',    'Типографика',  'Типографика',  'Типографика',  'pages',    'tipografika',  'index',    'index',    1481290625, 1481556495);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (63,   '0',    'Вакансии', 'Вакансии', 'Вакансии', 'Вакансии', 'pages',    'vacancies',    'children_menu_in_bottom',  'index',    1481529510, 1481555181);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (64,   '0',    'Написать директору',   'Написать директору',   'Написать директору',   'Написать директору',   'pages',    'dir',  'index',    'index',    1481554693, 1481555091);
INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (65,   63, 'Бухгалтер',    'Бухгалтер',    'Бухгалтер',    'Бухгалтер',    'pages',    'buhgalter',    'index',    'index',    1481555152, NULL);

CREATE TABLE "menus" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL,
  "class" text NULL
);

INSERT INTO "menus" ("id", "name", "class") VALUES (2,  'Главное меню админки', '');
INSERT INTO "menus" ("id", "name", "class") VALUES (4,  'Верхнее меню', 'nav navbar-nav top-menu');
INSERT INTO "menus" ("id", "name", "class") VALUES (7,  'Боковое меню', 'aside-menu');

CREATE TABLE "menus_items" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "parent_id" integer NOT NULL,
  "menu_id" integer NOT NULL,
  "name" text NOT NULL,
  "url" text NOT NULL,
  "sort" text NOT NULL,
  "class" text NULL,
  "show_page" integer DEFAULT '-1',
  FOREIGN KEY ("menu_id") REFERENCES "menus" ("id") ON DELETE CASCADE
);

INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (15, '0',    2,  'Страницы', '/admin/pages', '1');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (16, '0',    2,  'Менеджер меню',    '/admin/menus_manager', '20');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (17, '0',    2,  'Компоненты',   '/admin/components_manager',    '30');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (18, '0',    2,  'Модули',   '/admin/modules_manager',   '40');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (19, '0',    2,  'Настройки',    '/admin/config',    '50');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (20, '0',    2,  'Пользователи', '/admin/users', '60');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (31, '0',    4,  'Главная',  '/',    '1');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (32, '0',    4,  'Контакты', '/contacts',    '5');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (39, '0',    7,  'Новости',  '/news',    '1');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (40, '0',    7,  'Вакансии', '/vacancies',   '2');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (41, '0',    7,  'Галерея',  '/gallery', '3');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (42, '0',    7,  'Типографика',  '/tipografika', '4');

CREATE TABLE "news" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "url" text NOT NULL,
  "header" text NOT NULL,
  "overview" text NOT NULL,
  "photo" text NOT NULL,
  "text" text NOT NULL,
  "title" text NOT NULL,
  "keywords" text NOT NULL,
  "description" text NOT NULL,
  "date_create" integer NOT NULL,
  "date_edit" integer NOT NULL,
  "date_publish" integer NOT NULL,
  "parent_id" integer NOT NULL,
  "is_category" integer NOT NULL
);


INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (1,  'dobro-pozhalovat', 'Добро пожаловать!',    'Наш новый сайт открылся! И мы очень рады, что вы здесь.',  'ub4fstxhze.jpg',   'Итак, добро пожаловать на наш новый сайт. Теперь всё по-новому. Мы полностью обновили не только внешний вид но и добавили новый функционал. Наши основные разделы можно посмотреть в главном меню. Наш сайт теперь адаптивен. И если вы зашли на наш сайт с телефона или планшета, то вы, наверное, сразу заметили, как удобно им стало пользоваться. Это было непросто, но мы постарались. Потому что мы заботимся о наших посетителях.', 'Добро пожаловать!',    'Добро пожаловать!',    'Наш новый сайт открылся! И мы очень рады, что ты здесь.',  1480489722, 1480492057, 1480489260, '0',    '0');
INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (2,  'tsvety', 'Цветы',    'Описание 1',  '1.jpg',   'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eget viverra nisl, vitae ullamcorper nulla. Ut porta enim nunc. Suspendisse iaculis nisi a magna dapibus aliquet. Curabitur auctor, nulla vitae aliquet laoreet, sem urna tempor arcu, pulvinar iaculis libero nulla quis lectus. Aenean scelerisque pharetra lorem, in laoreet leo molestie quis. Morbi ac viverra orci. Vivamus molestie tortor sed ipsum luctus commodo. Morbi viverra nisl et sollicitudin posuere. Fusce pretium, felis ac iaculis auctor, turpis dolor ullamcorper elit, eget hendrerit libero velit eget risus. Suspendisse nulla magna, ullamcorper quis orci semper, fringilla vehicula mauris. Donec luctus enim neque, ut egestas odio luctus et. Mauris sit amet eleifend libero. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 'Цветы!',    'Цветы!',    'Цветы Цветы Цветы',  1480489722, 1480492057, 1480489260, '0',    '0');
INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (3,  'novost-dnya', 'Новость дня', 'Описание 2',  '2.jpg',   'Quisque condimentum quam sit amet mauris dictum, rutrum sollicitudin erat placerat. Curabitur magna nibh, pulvinar faucibus nisl ut, consequat posuere urna. Maecenas augue neque, euismod eget nunc quis, vestibulum posuere enim. Etiam nec dui vestibulum, pretium magna ullamcorper, mollis dui. Suspendisse malesuada elit massa, sit amet pellentesque enim pretium aliquam. Praesent nec dui lectus. Donec vehicula vel purus ac maximus. Donec sed tristique augue. Proin ac sapien posuere, interdum nisi non, tempus sem. Vivamus nec vulputate enim. Integer hendrerit ultrices ipsum.Integer fermentum libero ac enim ultrices, quis scelerisque massa rhoncus. Nam sagittis tempus nisl vel lacinia. Sed blandit velit et massa dignissim pretium. Nam placerat ante viverra est faucibus, eget efficitur enim consequat. Duis sit amet venenatis nisl, vitae efficitur nibh. Integer ultrices risus non lectus dictum, at efficitur orci tristique. Nulla porta libero magna, eu lacinia nisl iaculis id. In ut arcu ut massa fringilla tempor eget id nisl. Morbi lectus justo, volutpat non dolor luctus, blandit varius massa. Etiam neque lectus, lobortis id ultrices ut, pharetra a nisl. Pellentesque ultrices, diam ac tincidunt bibendum, purus elit tincidunt ipsum, imperdiet blandit est nulla sit amet elit. Nullam ac sollicitudin turpis. Sed vestibulum hendrerit faucibus.', 'Новость дня!',    'Новость дня!',    'Новость дня Новость дня Новость дня',  1480489722, 1480492057, 1480489260, '0',    '0');
INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (4,  'koe-chto-o-prirode', 'Кое что о природе',    'Описание 3',  '3.jpg',   'Quisque condimentum quam sit amet mauris dictum, rutrum sollicitudin erat placerat. Curabitur magna nibh, pulvinar faucibus nisl ut, consequat posuere urna. Maecenas augue neque, euismod eget nunc quis, vestibulum posuere enim. Etiam nec dui vestibulum, pretium magna ullamcorper, mollis dui. Suspendisse malesuada elit massa, sit amet pellentesque enim pretium aliquam. Praesent nec dui lectus. Donec vehicula vel purus ac maximus. Donec sed tristique augue. Proin ac sapien posuere, interdum nisi non, tempus sem. Vivamus nec vulputate enim. Integer hendrerit ultrices ipsum.Integer fermentum libero ac enim ultrices, quis scelerisque massa rhoncus. Nam sagittis tempus nisl vel lacinia. Sed blandit velit et massa dignissim pretium. Nam placerat ante viverra est faucibus, eget efficitur enim consequat. Duis sit amet venenatis nisl, vitae efficitur nibh. Integer ultrices risus non lectus dictum, at efficitur orci tristique. Nulla porta libero magna, eu lacinia nisl iaculis id. In ut arcu ut massa fringilla tempor eget id nisl. Morbi lectus justo, volutpat non dolor luctus, blandit varius massa. Etiam neque lectus, lobortis id ultrices ut, pharetra a nisl. Pellentesque ultrices, diam ac tincidunt bibendum, purus elit tincidunt ipsum, imperdiet blandit est nulla sit amet elit. Nullam ac sollicitudin turpis. Sed vestibulum hendrerit faucibus.Cras bibendum, justo in hendrerit tempor, eros metus consequat lacus, eu ornare diam quam at neque. Vestibulum venenatis augue tempus magna faucibus, a hendrerit turpis consequat. Duis non massa cursus, consequat leo nec, feugiat magna. Pellentesque imperdiet risus vel ipsum luctus pretium. Duis non nisl gravida, placerat diam et, euismod velit. Sed dui mauris, porta vitae tincidunt at, pulvinar eget dui. Fusce iaculis purus at nunc fringilla rutrum. Quisque mi odio, cursus eget orci in, aliquam porttitor nulla. Phasellus commodo, lectus sit amet vehicula malesuada, tortor odio viverra arcu, quis consectetur odio est in ligula. Praesent venenatis maximus ligula quis aliquet. Phasellus fermentum tellus in sapien tempor porttitor. Suspendisse potenti. Praesent ut lobortis urna.', 'Кое что о природе!',    'Кое что о природе!',    'Кое что о природе Кое что о природе Кое что о природе',  1480489722, 1480492057, 1480489260, '0',    '0');
INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (5,  'zhivotnye', 'Животные',    'Описание 4',  '4.jpg',   'Quisque condimentum quam sit amet mauris dictum, rutrum sollicitudin erat placerat. Curabitur magna nibh, pulvinar faucibus nisl ut, consequat posuere urna. Maecenas augue neque, euismod eget nunc quis, vestibulum posuere enim. Etiam nec dui vestibulum, pretium magna ullamcorper, mollis dui. Suspendisse malesuada elit massa, sit amet pellentesque enim pretium aliquam. Praesent nec dui lectus. Donec vehicula vel purus ac maximus. Donec sed tristique augue. Proin ac sapien posuere, interdum nisi non, tempus sem. Vivamus nec vulputate enim. Integer hendrerit ultrices ipsum.Integer fermentum libero ac enim ultrices, quis scelerisque massa rhoncus. Nam sagittis tempus nisl vel lacinia. Sed blandit velit et massa dignissim pretium. Nam placerat ante viverra est faucibus, eget efficitur enim consequat. Duis sit amet venenatis nisl, vitae efficitur nibh. Integer ultrices risus non lectus dictum, at efficitur orci tristique. Nulla porta libero magna, eu lacinia nisl iaculis id. In ut arcu ut massa fringilla tempor eget id nisl. Morbi lectus justo, volutpat non dolor luctus, blandit varius massa. Etiam neque lectus, lobortis id ultrices ut, pharetra a nisl. Pellentesque ultrices, diam ac tincidunt bibendum, purus elit tincidunt ipsum, imperdiet blandit est nulla sit amet elit. Nullam ac sollicitudin turpis. Sed vestibulum hendrerit faucibus.Cras bibendum, justo in hendrerit tempor, eros metus consequat lacus, eu ornare diam quam at neque. Vestibulum venenatis augue tempus magna faucibus, a hendrerit turpis consequat. Duis non massa cursus, consequat leo nec, feugiat magna. Pellentesque imperdiet risus vel ipsum luctus pretium. Duis non nisl gravida, placerat diam et, euismod velit. Sed dui mauris, porta vitae tincidunt at, pulvinar eget dui. Fusce iaculis purus at nunc fringilla rutrum. Quisque mi odio, cursus eget orci in, aliquam porttitor nulla. Phasellus commodo, lectus sit amet vehicula malesuada, tortor odio viverra arcu, quis consectetur odio est in ligula. Praesent venenatis maximus ligula quis aliquet. Phasellus fermentum tellus in sapien tempor porttitor. Suspendisse potenti. Praesent ut lobortis urna.Pellentesque placerat odio dolor, nec convallis ex laoreet id. Nam mollis eleifend mattis. Donec quis eros lacus. Phasellus eu posuere diam. Nunc a ipsum pretium leo volutpat bibendum. Cras ac orci eu ipsum sollicitudin fermentum. Proin sit amet leo ut sem aliquet dapibus. Sed efficitur lectus sed imperdiet facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent elementum interdum vulputate.', 'Животные!',    'Животные!',    'Животные Животные Животные',  1480489722, 1480492057, 1480489260, '0',    '0');
INSERT INTO "news" ("id", "url", "header", "overview", "photo", "text", "title", "keywords", "description", "date_create", "date_edit", "date_publish", "parent_id", "is_category") VALUES (6,  'dobrogo-dnya', 'Доброго дня',    'Описание 5',  '5.jpg',   'Pellentesque placerat odio dolor, nec convallis ex laoreet id. Nam mollis eleifend mattis. Donec quis eros lacus. Phasellus eu posuere diam. Nunc a ipsum pretium leo volutpat bibendum. Cras ac orci eu ipsum sollicitudin fermentum. Proin sit amet leo ut sem aliquet dapibus. Sed efficitur lectus sed imperdiet facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent elementum interdum vulputate.', 'Доброго дня!',    'Доброго дня!',    'Доброго дня Доброго дня Доброго дня',  1480489722, 1480492057, 1480489260, '0',    '0');

CREATE TABLE "pages" (
  "id" integer NULL PRIMARY KEY AUTOINCREMENT,
  "main_id" integer NOT NULL,
  "text" text NOT NULL
);

INSERT INTO "pages" ("id", "main_id", "text") VALUES (1,    1,  '<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими безорфографичный образ жизни.</p><p>Однажды одна маленькая строчка рыбного текста по имени Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить себя с толку. Он собрал семь своих заглавных букв, подпоясал инициал за пояс и пустился в дорогу. Взобравшись на первую вершину курсивных гор, бросил он последний взгляд назад, на силуэт своего родного города Буквоград, на заголовок деревни Алфавит и на подзаголовок своего переулка Строчка. Грустный риторический вопрос скатился по его щеке и он продолжил свой путь.&nbsp;</p><p>По дороге встретил текст рукопись. Она предупредила его: «В моей стране все переписывается по несколько раз. Единственное, что от меня осталось, это приставка «и». Возвращайся ты лучше в свою безопасную страну». Не послушавшись рукописи, наш текст продолжил свой путь. Вскоре ему повстречался коварный составитель.</p>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (41,   43, '<h3>Телефоны:</h3>
+7 (495) 111-11-11 - отдел продаж<br>
+7 (495) 111-11-11 - отдел поддержки

<h3>E-Mail</h3>
info@site.ru - отдел продаж<br>
support@site.ru - отдел поддержки

<h3>Адрес</h3>
123454 г. Москва, Красная Площадь, 4

<h3>Часы работы</h3>
пн-пт: 9<sup>00</sup> - 18<sup>00</sup><br>
сб,вс: выходной

<h3>Мы в социальных сетях</h3>
<a href="//vk.com">vk.com</a> - В контакте<br>
<a href="//facebook.com">facebook.com</a> - Фейсбук

<h3>Реквизиты</h3>
ООО "Софт"<br>
ИНН: 6545343645646<br>
ОГРН: 65654564654654

<h3>Напишите нам:</h3>
<p>{plugin:feedback=42}</p>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (51,   59, '<h2 class="bg-primary">Проверка строчных элементов</h2>

<p><a href="#">Ссылка</a>, <a href="#">посещенная ссылка</a>, <a href="#">ссылка при наведении</a>, <span>обычный текст</span>, <strong>полужирный текст</strong>, <b>полужирный текст 2</b>, <em>наклонный текст</em>, <i>наклонный текст 2</i>
<br>Цвет ссылок указан на макете, если его нет, то желательно оставить его синим по умолчанию, в редких случаях серым, и красным при наведении, подчеркивание также по умолчанию должно быть, при наведении подчеркивание можно убрать.</p><h2 class="bg-primary">Проверка блочных элементов</h2><h1>Заголовок первого уровня</h1><h2>Заголовок 2 уровня</h2><h3>Заголовок 3 уровня</h3><h4>Заголовок 4 уровня</h4>

<p>Параграф</p>

<p>Параграф и отступы между ними</p>

<p>Параграф</p><h2 class="bg-primary">Проверка списков</h2><h3>Маркированный список</h3>
<ul>
    <li>Маркеры должны быть!!! И не должны вылазить!!</li>
    <li>Автотор</li>
    <li>Продукты питания комбинат</li>
    <li>СОЯ</li>
    <li>Морской торговый порт</li>
    <li>Калининградский судоремонтный завод</li>
    <li>Калининградский рыбоконсервный комбинат, просто длинный элемент списка Калининградский рыбоконсервный<a href="#"> А это ссылка</a> комбинат , пожалуй самый длинный элемент, Калининградский рыбоконсервный комбинат</li>
    <li>Калининградские деликатесы</li>
    <li>Светловский мясокомбинат</li>
    <li>Союз ТТ и десятки других предприятий</li>
</ul><h3>Нумерованный список</h3>
<ol>
    <li>Маркеры должны быть!!! И не должны вылазить!!</li>
    <li>Автотор</li>
    <li>Продукты питания комбинат</li>
    <li>СОЯ</li>
    <li>Морской торговый порт</li>
    <li>Калининградский судоремонтный завод</li>
    <li>Калининградский рыбоконсервный комбинат, просто длинный элемент списка Калининградский рыбоконсервный<a href="#"> А это ссылка</a> комбинат , пожалуй самый длинный элемент, Калининградский рыбоконсервный комбинат</li>
    <li>Калининградские деликатесы</li>
    <li>Светловский мясокомбинат</li>
    <li>Союз ТТ и десятки других предприятий</li>
</ol>

<p>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>

<p>Параграф</p>

<p>Параграф и отступы между ними</p>

<p>Параграф</p><h2 class="bg-primary">Пример таблицы</h2>
<table class="table">
<tbody>
    <tr>
<th>#
</th>
<th>Заголовок
</th>
<th>должен отличаться
</th>
    </tr>
    <tr>
        <td>1</td>
        <td>от обычных</td>
        <td>ячеек</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>Проверь вертикальное выравнивание по умолчанию!!!!</td>
    </tr>
</tbody>
</table>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (52,   60, '<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими безорфографичный образ жизни.</p><p>Однажды одна маленькая строчка рыбного текста по имени Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить себя с толку. Он собрал семь своих заглавных букв, подпоясал инициал за пояс и пустился в дорогу. Взобравшись на первую вершину курсивных гор, бросил он последний взгляд назад, на силуэт своего родного города Буквоград, на заголовок деревни Алфавит и на подзаголовок своего переулка Строчка. Грустный риторический вопрос скатился по его щеке и он продолжил свой путь.&nbsp;</p><p>По дороге встретил текст рукопись. Она предупредила его: «В моей стране все переписывается по несколько раз. Единственное, что от меня осталось, это приставка «и». Возвращайся ты лучше в свою безопасную страну». Не послушавшись рукописи, наш текст продолжил свой путь. Вскоре ему повстречался коварный составитель.</p>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (53,   61, '<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими безорфографичный образ жизни.</p><p>Однажды одна маленькая строчка рыбного текста по имени Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить себя с толку. Он собрал семь своих заглавных букв, подпоясал инициал за пояс и пустился в дорогу. Взобравшись на первую вершину курсивных гор, бросил он последний взгляд назад, на силуэт своего родного города Буквоград, на заголовок деревни Алфавит и на подзаголовок своего переулка Строчка. Грустный риторический вопрос скатился по его щеке и он продолжил свой путь.&nbsp;</p><p>По дороге встретил текст рукопись. Она предупредила его: «В моей стране все переписывается по несколько раз. Единственное, что от меня осталось, это приставка «и». Возвращайся ты лучше в свою безопасную страну». Не послушавшись рукописи, наш текст продолжил свой путь. Вскоре ему повстречался коварный составитель.</p>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (54,   62, '<table class="table">
<tbody>
    <tr>
<th>№
</th>
<th>Тариф
</th>
<th>Цена
</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>3000 р.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>5000 р.</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        <td>7000 р.</td>
    </tr>
</tbody>
</table>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (55,   63, '<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими безорфографичный образ жизни.</p><p>Однажды одна маленькая строчка рыбного текста по имени Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить себя с толку. Он собрал семь своих заглавных букв, подпоясал инициал за пояс и пустился в дорогу. Взобравшись на первую вершину курсивных гор, бросил он последний взгляд назад, на силуэт своего родного города Буквоград, на заголовок деревни Алфавит и на подзаголовок своего переулка Строчка. Грустный риторический вопрос скатился по его щеке и он продолжил свой путь.&nbsp;</p><p>По дороге встретил текст рукопись. Она предупредила его: «В моей стране все переписывается по несколько раз. Единственное, что от меня осталось, это приставка «и». Возвращайся ты лучше в свою безопасную страну». Не послушавшись рукописи, наш текст продолжил свой путь. Вскоре ему повстречался коварный составитель.</p>');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (56,   64, 'Здесь вы можете написать нашему директору:<br>{plugin:feedback=47}');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (57,   65, 'Вакансия закрыта');
INSERT INTO "pages" ("id", "main_id", "text") VALUES (58,   66, 'Вакансия закрыта');

CREATE TABLE "users" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "login" text NOT NULL,
  "password" text NOT NULL,
  "email" text NOT NULL,
  "access_level" integer NOT NULL DEFAULT '0',
  "date_add" integer NOT NULL,
  "date_edit" integer NOT NULL,
  "active" integer NOT NULL
);

INSERT INTO "users" ("id", "login", "password", "email", "access_level", "date_add", "date_edit", "active") VALUES (1,  'admin',    '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.ru',   2,  1234567890, 1365602852, 1);
INSERT INTO "users" ("id", "login", "password", "email", "access_level", "date_add", "date_edit", "active") VALUES (2,  'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test.ru', '0',    1365602886, 1365602886, 1);

CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('pages',  '58');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('installed_modules',  '31');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('users',  '2');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('menus_items',    '42');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('gallery_categories', '12');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('gallery_items',  '105');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('menus',  '7');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('main',   '66');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('activated_modules',  '47');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('news',   '14');
