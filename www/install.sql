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


INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (1,	'jQuery (ядро)',	'addon',	'before',	'0',	2,	1,	'jquery',	NULL,	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (2,	'jQuery (ядро for BackEnd)',	'addon',	'before',	1,	1,	1,	'jquery',	NULL,	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (7,	'Вкладки',	'addon',	'after',	1,	5,	11,	'tabs',	NULL,	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (9,	'Fancy Box',	'addon',	'after',	1,	3,	2,	'fancybox',	'1,2,3,4,5',	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (10,	'Fancy Box для frontend''a',	'addon',	'after',	'0',	3,	2,	'fancybox',	'1,2,3,4,5',	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (18,	'Редактор кода Codemirror',	'addon',	'after',	1,	2,	19,	'codemirror',	'',	'',	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (19,	'Главное меню админки',	'block',	'main_menu',	1,	4,	14,	'menu',	's:1:"2";',	NULL,	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (29,	'Главное меню сайта',	'block',	'top_menu',	'0',	5,	14,	'menu',	's:1:"4";',	'',	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (40,	'301 редирект',	'addon',	'before',	'0',	1,	25,	'redirect_301',	'/test|/kontakty',	'',	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (41,	'Текстовый редактор jodit',	'addon',	'after',	1,	6,	28,	'jodit',	'',	'',	(julianday('now') - 2440587.5)*86400.0);
INSERT INTO "activated_modules" ("id", "name", "type", "position", "back_end", "sort", "module_id", "module_dir", "params", "sections", "date_edit") VALUES (46,	'Боковое меню',	'block',	'aside',	'0',	4,	14,	'menu',	's:1:"7";',	'',	(julianday('now') - 2440587.5)*86400.0);

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


CREATE TABLE "gallery_items" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "category_id" integer NOT NULL,
  "image" text NOT NULL,
  "text" text NOT NULL,
  "sort" integer NULL DEFAULT '1',
  "date_add" integer NOT NULL,
  FOREIGN KEY ("category_id") REFERENCES "gallery_categories" ("id") ON DELETE CASCADE ON UPDATE NO ACTION
);


CREATE TABLE "installed_modules" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL,
  "type" text NOT NULL,
  "dir" text NULL,
  "version" text NOT NULL,
  "date_add" integer NULL
, "description" text NULL);

INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (1,  'jQuery',   'addon',    'jquery',   '1.2.6',    (julianday('now') - 2440587.5)*86400.0, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (2,  'FancyBox', 'addon',    'fancybox', '2.07', (julianday('now') - 2440587.5)*86400.0, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (11, 'Tabs', 'addon',    'tabs', '1.0',  (julianday('now') - 2440587.5)*86400.0, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (13, 'Блок HTML кода',   'block',    'custom_html',  '1.0',  (julianday('now') - 2440587.5)*86400.0, 'Модуль позволяет добавлять на станицу пользовательский html код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (14, 'Block menu',   'block',    'menu', '0.1',  (julianday('now') - 2440587.5)*86400.0, NULL);
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (19, 'Codemirror',   'addon',    'codemirror',   '0.9',  (julianday('now') - 2440587.5)*86400.0, 'Codemirror is a versatile text editor implemented in JavaScript for the browser. It is specialized for editing code, and comes with a number of language modes and addons that implement more advanced editing functionaly.');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (24, 'Форма обратной связи', 'plugin',   'feedback', '2.0',  (julianday('now') - 2440587.5)*86400.0, 'Стандартная форма обратной связи');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (25, '301 редирект', 'addon',    'redirect_301', '1.0',  (julianday('now') - 2440587.5)*86400.0, '
Пример: 
/old_url.html|/ne_url.html
/catalog|/katalog
/contacts.html|/kontakty.html');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (28, 'Текстовый редактор jodit',  'addon',    'jodit', '3.1.95',  (julianday('now') - 2440587.5)*86400.0, '');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (30, 'Анонс новостей',   'block',    'news_announce',    '2.0',  (julianday('now') - 2440587.5)*86400.0, 'Анонс новостей');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (31, 'Слайдер CUBE', 'block',    'cube_slider',  '1.4',  (julianday('now') - 2440587.5)*86400.0, 'Слайдер в виде вращающегося куба.');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (32, 'Блок HTML кода',   'plugin',    'custom_html',  '1.0',  (julianday('now') - 2440587.5)*86400.0, 'Модуль позволяет добавлять на станицу пользовательский html код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (33, 'Блок выполняемого кода',   'plugin',    'custom_script',  '1.0',  (julianday('now') - 2440587.5)*86400.0, 'Модуль позволяет добавлять на станицу пользовательский выполняемый код');
INSERT INTO "installed_modules" ("id", "name", "type", "dir", "version", "date_add", "description") VALUES (34, 'Блок выполняемого кода',   'block',    'custom_script',  '1.0',  (julianday('now') - 2440587.5)*86400.0, 'Модуль позволяет добавлять на станицу пользовательский выполняемый код');


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

INSERT INTO "main" ("id", "parent_id", "name", "title", "keywords", "description", "component", "url", "view", "theme_view", "date_add", "date_edit") VALUES (1,    '0',    'Главная страница', 'Сайт', 'Ключевые слова',   'Описание главной страницы',    'pages',    '/',    'no_breadcrumbs',   'index', (julianday('now') - 2440587.5)*86400.0, (julianday('now') - 2440587.5)*86400.0);

CREATE TABLE "menus" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL,
  "class" text NULL
);

INSERT INTO "menus" ("id", "name", "class") VALUES (2,  'Главное меню админки', '');

CREATE TABLE "menus_items" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "parent_id" integer NOT NULL,
  "menu_id" integer NOT NULL,
  "name" text NOT NULL,
  "url" text NOT NULL,
  "sort" text NOT NULL,
  "class" text NULL,
  FOREIGN KEY ("menu_id") REFERENCES "menus" ("id") ON DELETE CASCADE
);

INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (15, '0',    2,  'Страницы', '/admin/pages', '1');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (16, '0',    2,  'Менеджер меню',    '/admin/menus_manager', '20');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (17, '0',    2,  'Компоненты',   '/admin/components_manager',    '30');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (18, '0',    2,  'Модули',   '/admin/modules_manager',   '40');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (19, '0',    2,  'Настройки',    '/admin/config',    '50');
INSERT INTO "menus_items" ("id", "parent_id", "menu_id", "name", "url", "sort") VALUES (20, '0',    2,  'Пользователи', '/admin/users', '60');

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


CREATE TABLE "pages" (
  "id" integer NULL PRIMARY KEY AUTOINCREMENT,
  "main_id" integer NOT NULL,
  "text" text NOT NULL
);

INSERT INTO "pages" ("id", "main_id", "text") VALUES (1,    1,  '<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу Семантика большого языкового океана. Маленький ручеек Даль журчит по всей стране и обеспечивает ее всеми необходимыми правилами. Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими безорфографичный образ жизни.</p><p>Однажды одна маленькая строчка рыбного текста по имени Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее о злых запятых, диких знаках вопроса и коварных точках с запятой, но текст не дал сбить себя с толку. Он собрал семь своих заглавных букв, подпоясал инициал за пояс и пустился в дорогу. Взобравшись на первую вершину курсивных гор, бросил он последний взгляд назад, на силуэт своего родного города Буквоград, на заголовок деревни Алфавит и на подзаголовок своего переулка Строчка. Грустный риторический вопрос скатился по его щеке и он продолжил свой путь.&nbsp;</p><p>По дороге встретил текст рукопись. Она предупредила его: «В моей стране все переписывается по несколько раз. Единственное, что от меня осталось, это приставка «и». Возвращайся ты лучше в свою безопасную страну». Не послушавшись рукописи, наш текст продолжил свой путь. Вскоре ему повстречался коварный составитель.</p>');

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

INSERT INTO "users" ("id", "login", "password", "email", "access_level", "date_add", "date_edit", "active") VALUES (1,  'admin',    '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.ru',   2,  (julianday('now') - 2440587.5)*86400.0, (julianday('now') - 2440587.5)*86400.0, 1);

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
