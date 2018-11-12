<?php
class controller_component_core_news extends component
{
    protected $order_by;
    protected $is_asc;
    function __construct($config, $url, $component, $dbh)
    {
        parent::__construct($config, $url, $component, $dbh);
        if (!isset($_SESSION['news_backend_order_by'])) $_SESSION['news_backend_order_by'] = 'date_publish';
        if (!isset($_SESSION['news_backend_is_asc'])) $_SESSION['news_backend_is_asc'] = false;
        $this->order_by = $_SESSION['news_backend_order_by'];
        $this->is_asc = $_SESSION['news_backend_is_asc'];
        
        $r = $this->dbh->row("SELECT url FROM main WHERE component='".$this->url['component']."'");
        $this->data['front_end_component_url'] = $r['url'];
        $this->data['component'] = $this->url['component'];
        $this->data['order_by'] = $this->order_by;
        $this->data['is_asc'] = $this->is_asc;
        if (count($this->url['actions']) == 1 && $this->url['actions'][0] == 'index') {;
            $this->data['base_url'] = SITE_URL.'/admin/'.$this->url['component'];
            $this->data['upper_url'] = '';
        } else {
            $this->data['base_url'] = SITE_URL.'/admin/'.$this->url['component'].'/'.implode('/', $this->url['actions']);
            $actions = $this->url['actions'];
            array_pop($actions);
            $this->data['upper_url'] = SITE_URL.'/admin/'.$this->url['component'].'/'.implode('/', $actions);
        }
    }
    /**
    * Отображает таблицу статей и категорий, вложенных в категорию с $parent_id
    * Если указан $parent_id = 0, то выводятся элементы, вложенные в корневую категорию
    * @param int $parent_id идентификатор категории
    * @return array готовую страницу $this->page
    */
    protected function show_childrens($parent_id)
    {
        if (isset($_POST['delete_article'])) $this->model->delete_article($_POST['delete_article']);
        if (isset($_POST['delete_category'])) $this->model->delete_category($_POST['delete_category']);
        $items_count = $this->helper_pagination->total = $this->model->count_childrens($parent_id);
        $this->helper_pagination->limit = $items_per_page = 20;
        $pages_count = ceil($items_count/$items_per_page);
        $current_page = isset($this->url['params']['page']) ? intval($this->url['params']['page']) : 0;
        if ($current_page > $pages_count) $current_page = $pages_count;
        elseif ($current_page < 1) $current_page = 1;
        $this->helper_pagination->page = $current_page;
        $items = $this->model->fetch_childrens($parent_id, ($current_page-1)*$items_per_page, $items_per_page, $this->order_by, $this->is_asc);
        if ($parent_id != 0) {
            $category = $this->model->get($parent_id);
        }
        $this->data = array_merge($this->data, compact('items_count', 'pages_count', 'current_page', 'items'));
        
        $this->data['page_header'] = isset($category) ? $category['header'] : 'Все новости (корневая категория)';
        $this->page['title'] = 'Таблица новостей';
        $this->data['pagination'] = $this->helper_pagination->render();
        $this->page['html'] = $this->load_view('table');
        return $this->page;
    }
    /**
    * Отображает статью или категорию в режиме редактирования
    * @param array $item массив с данными из записи в БД или пустой если создаем новую сущность
    * @return array готовую страницу $this->page
    */
    protected function show_editor($item)
    {
        $errors = array();
        $back_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/'.$this->url['component'];
        if (isset($_POST['back_url'])) $back_url = $_POST['back_url'];
        if (isset($_POST['save'])) {
            $item = array_merge($item, $_POST['item']);
            if ($item['header'] != '') {
                if ($item['url'] == '') $item['url'] = $this->str2url($item['header']);
                if ($item['title'] == '') $item['title'] = $item['header'];
                if ($item['keywords'] == '') $item['keywords'] = $item['header'];
            } else {
                $errors[] = 'Напишите заголовок';
            }
            $conflict_id = $this->model->find_conflict_id($item['url'], $item['parent_id']);
            if ($conflict_id != 0 && $conflict_id != $item['id']) $errors[] = 'URL конфликтует с уже имеющимися в этой категории, поменяйте его на вкладке SEO.';
            if ($item['is_category'] == 0) {
                if ($item['text'] == '') $errors[] = 'Статья новости пустая, напишите что-нибудь';
                if ($item['overview'] == '' && $item['text'] != '') $item['overview'] = mb_substr(strip_tags($item['text']), 0, 250).'...';
            }
            if (mb_strlen($item['overview']) > 250) $item['overview'] = mb_substr($item['overview'], 0, 247).'...';
            if ($item['description'] == '') $item['description'] = $item['overview'];
            $item['date_edit'] = time();
            if ($item['date_publish'] == '') {
                $item['date_publish'] = time();
            } else {
                $item['date_publish'] = date_parse_from_format('d.m.Y H:i', $item['date_publish']);
                if (!empty($item['date_publish']['errors'])) {
                    $errors[] = 'Время публикации указано неверно. '.implode(' ', $item['date_publish']['errors']);
                    $item['date_publish'] = time();
                } else {
                    $item['date_publish'] = mktime(
                        $item['date_publish']['hour'],
                        $item['date_publish']['minute'],
                        0,
                        $item['date_publish']['month'],
                        $item['date_publish']['day'],
                        $item['date_publish']['year']
                    );
                }
            }
            if ($item['parent_id'] != 0) {
                $parent = $this->model->get($item['parent_id']);
                if ($parent['date_publish'] > $item['date_publish']) {
                    $errors[] = 'Дата публикации раньше, чем у родительской категории ('.date('d.m.Y H:i', $parent['date_publish']).')';
                }
            }
            if ($item['id'] != 0 && $item['is_category'] == 1) $this->model->adjust_childs_date_publish($item);
            
            if (empty($errors) && $item['is_category'] == 0) {
                $upload_dir = ROOT_DIR.'/uploads/modules/'.$this->url['component'].'/';
                
                if (isset($_POST['remove_photo'])) {
                    $item = array_merge($item, $_POST['item']);
                    if (file_exists($upload_dir.$item['photo'])) unlink($upload_dir.$item['photo']);
                    if (file_exists($upload_dir.'/mini/'.$item['photo'])) unlink($upload_dir.'/mini/'.$item['photo']);
                    $item['photo'] = '';
                }
                if (!empty($_FILES['photo']['name'])) {
                    if (in_array(strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)), array('jpeg', 'jpg', 'png', 'gif'))) {
                    
                        $this->load_helper('image');
                        
                        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                        if (!is_dir($upload_dir.'/mini')) mkdir($upload_dir.'/mini', 0777, true);
                        
                        if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                            $image = $this->helper_image->img_upload(
                                'photo',
                                $this->component_config['image_max_width'],
                                $upload_dir,
                                $this->component_config['image_thumb_width'],
                                $this->component_config['image_thumb_height']
                            );
                            if (!empty($item['photo'])) {
                                if (file_exists($upload_dir.$item['photo'])) unlink($upload_dir.$item['photo']);
                                if (file_exists($upload_dir.'/mini/'.$item['photo'])) unlink($upload_dir.'/mini/'.$item['photo']);
                            }
                            $item['photo'] = $image;
                        } else {
                            $errors[] = 'Не удалось загрузить файл '.$_FILES['photo']['name'];
                        }
                    } else {
                        $errors[] = 'Файл для фотографии неизвестного формата. Выберите файл JPEG, PNG или GIF.';
                    }
                }
            }
            if (empty($errors)) {
                $new_id = $this->model->save($item);
                if ($new_id == 0) {
                    $errors[] = 'Произошла ошибка при сохранении. Попробуйте еще раз.';
                } else {
                    if ($item['id'] == 0) $this->redirect($back_url); //чтобы не остаться на странице добавления (элемент был новый)
                    else $new_item_url = $this->model->get_full_url($new_id); // получаем урл чтобы просмотреть изменения
                }
            }
        }
        $available_parents = $this->model->get_available_parents($item);
        $available_parents[] = array('id' => 0, 'header' => 'Корневая категория');
        $this->data = array_merge($this->data, compact('errors', 'back_url', 'item', 'upload_dir', 'new_item_url', 'available_parents'));
        $this->data['page_header'] = $item['is_category'] == 1 ? 'Редактирование категории' : 'Редактирование новости';
        if(count($this->data['available_parents']) > 1){
            $breadcrumb_url = SITE_URL . '/admin/' . $this->url['component'];
            foreach ($this->data['available_parents'] as $key => $parent) {
                $breadcrumb_url .= isset($parent['url'])?'/' . $parent['url']:'';
                if(isset($parent['url']))$this->helper_breadcrumbs->add($parent['header'], $breadcrumb_url);    
            }
        }else{
            $this->helper_breadcrumbs->add($this->data['available_parents'][0]['header'], SITE_URL . '/admin/' . $this->url['component']);
        }
        $this->page['title'] = 'Редактор новостей и категорий';
        $this->page['html'] = $this->load_view('editor');
        return $this->page;
    }
    public function action_index()
    {
        return $this->action_else();
    }
    /**
    * Маршрутизация
    * @return array готовую страницу $this->page
    */
    public function action_else()
    {
        if (count($this->url['actions']) == 1 && $this->url['actions'][0] == 'index') {
            $this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
            $parent_id = 0;// корневая категория
        } else {
            $item = $this->model->find_by_actions($this->url['actions']);
            $breadcrumb_url = SITE_URL . '/admin/' . $this->url['component']; 
            foreach($item['labels'] as $key_lb => $label){
                $breadcrumb_url .= '/' . $this->url['actions'][$key_lb];
                $this->helper_breadcrumbs->add($label,  $breadcrumb_url);
            }
            $this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
            $item = $item['item'];
            if ($item === false) return $this->action_404(); // элемент не найден
            elseif ($item['is_category'] == 0) return $this->show_editor($item); // статья
            else $parent_id = $item['id']; // пока не ясно что показывать, но родительская категория уже определена
        }
        // категория может отображаться по-разному в зависимости от указанных в URL параметров
        // do - команда что делать (по умолчанию просто показать вложенные эл-ты)
        if (isset($this->url['params']['do'])) switch ($this->url['params']['do']) {
            case 'edit':
            if ($parent_id != 0) return $this->show_editor($item); // редактирование категории
            else return $this->action_404(); // редактирование корневой категории запрещено (её по сути не существует, она только подразумевается)
            case 'add_category':
            $new_category = $this->model->new_category();
            $new_category['parent_id'] = $parent_id;
            if ($parent_id != 0 && $item['date_publish'] > time()) $new_category['date_publish'] = $item['date_publish'];
            return $this->show_editor($new_category);
            case 'add_article':
            $new_article = $this->model->new_article();
            $new_article['parent_id'] = $parent_id;
            if ($parent_id != 0 && $item['date_publish'] > time()) $new_article['date_publish'] = $item['date_publish'];
            return $this->show_editor($new_article);
            case 'order': // переключение сортировки в таблице
            if (!isset($this->url['params']['order_by'])) {
                return $this->$this->action_404(); //не хватет параметра order_by
            } elseif ($this->url['params']['order_by'] == $_SESSION['news_backend_order_by']) {
                $this->is_asc = $_SESSION['news_backend_is_asc'] = !$_SESSION['news_backend_is_asc'];
            } else {
                $this->is_asc = $_SESSION['news_backend_is_asc'] = true;
                $this->order_by = $_SESSION['news_backend_order_by'] = $this->url['params']['order_by'];
            }
            $this->redirect($this->data['base_url']);
            default:
            return $this->show_childrens($parent_id);
        } else {
            return $this->show_childrens($parent_id); //по умолчанию показываем таблицу вложенных элементов
        }
    }
    public function action_add() {
        $this->redirect('/admin/'.$this->url['component'].'/do=add_article');
    }
}