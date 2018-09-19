<?php 
class model_component_core_news extends model
{
    private $component = 'news';

    private $item_template = array(
        'id' => 0,
        'url' => '',
        'header' => '',
        'overview' => '',
        'photo' => '',
        'text' => '',
        'title' => '',
        'keywords' => '',
        'description' => '',
        'date_create' => 0,
        'date_edit' => 0,
        'date_publish' => 0,
        'parent_id' => 0,
        'is_category' => 0,
    );

    public function new_article()
    {
        $item = $this->item_template;
        $item['date_create'] = time();
        $item['date_publish'] = time();
        return $item;
    }


    public function new_category()
    {
        $item = $this->item_template;
        $item['date_create'] = time();
        $item['date_publish'] = time();
        $item['is_category'] = 1;
        return $item;
    }

    // сохранить элемент (если новый - то INSERT-ом, иначе - UPDATE-ом)
    public function save($item)
    {
        $keys = array_keys($this->item_template);
        foreach ($item as $key => $value) if (!in_array($key, $keys, true)) unset($item[$key]);

        if ($item['id'] == 0) {
            unset($item['id']);
            $fields = '('.implode(',', $keys).')';
            $placeholders = '(:'.implode(',:', $keys).')';
            $sql = "INSERT INTO news $fields VALUES $placeholders";
        } else {
            $set = array();
            foreach ($keys as $key) if ($key != 'id') $set[] = $key.'=:'.$key;
            $set = implode(',', $set);
            $sql = "UPDATE news SET $set WHERE id=:id";
        }
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute($item)) {
            if (isset($item['id'])) return $item['id'];
            else return $this->dbh->lastInsertId();
        } else {
            return 0;
        }
    }


    public function delete_article($id)
    {
        if (is_numeric($id)) {
            $article = $this->get($id);
            if (!empty($article['photo'])) {
                $upload_dir = ROOT_DIR.'/uploads/modules/'.$this->component.'/';
                if (file_exists($upload_dir.$article['photo'])) unlink($upload_dir.$article['photo']);
                if (file_exists($upload_dir.'/mini/'.$article['photo'])) unlink($upload_dir.'/mini/'.$article['photo']);
            }
            return $this->dbh->exec("DELETE FROM news WHERE id=$id");
        }
    }


    protected function delete_child_articles($parent_id)
    {
        $child_articles = $this->dbh->query("SELECT * FROM news WHERE parent_id=$parent_id AND is_category=0");
        foreach ($child_articles as $child_article) $this->delete_article($child_article['id']);
    }
    protected function get_child_categories($parent_id)
    {
        return $this->dbh->query("SELECT id FROM news WHERE parent_id=$parent_id AND is_category=1");
    }
    // удалить категорию и рекурсивно всех потомков
    public function delete_category($id)
    {
        if (is_numeric($id)) {
            $this->delete_child_articles($id);
            $child_categories = $this->get_child_categories($id);
            foreach ($child_categories as $child_category) $this->delete_category($child_category['id']);
            $this->delete_article($id); // насамом деле удаляем категорию (просто нерекурсивно, поэтому отличие от удаления статьи нет)
        }
    }


    public function get($id)
    {
        if (is_numeric($id)) return $this->dbh->row("SELECT * FROM news WHERE id=$id");
    }

    // читать потомков постранично с заданной сортировкой
    public function fetch_childrens($parent_id, $offset, $limit, $order_by, $is_asc)
    {
        if (is_numeric($parent_id) && is_numeric($offset) && is_numeric($limit) && in_array($order_by, array_keys($this->new_article()))) {
            $order_type = $is_asc ? 'ASC' : 'DESC';
            return $this->dbh->query("SELECT * FROM news WHERE parent_id=$parent_id ORDER BY $order_by $order_type LIMIT $offset,$limit");
        }
    }

    public function count_childrens($parent_id)
    {
        if (is_numeric($parent_id)) {
            $r = $this->dbh->row("SELECT COUNT(id) AS c FROM news WHERE parent_id=$parent_id");
            return $r ? $r['c'] : 0;
        }
    }

    // найти элемент, соответствующий данной комбинации экшнов в URL
    public function find_by_actions($url_actions)
    {
        $c = count($url_actions);
        $parent_id = 0;
        $result = array(
            'item' => false,
            'labels' => array(), // заголовки родительских категорий (нужны для breadcrumbs)
        );
         if ($c == 0) return $result;
         foreach ($url_actions as $n => $url) {
            $category = $this->dbh->row("SELECT * FROM news WHERE parent_id=$parent_id AND url='$url' AND is_category=1 LIMIT 1");
            if ($n == $c-1) {
                $article = $this->dbh->row("SELECT * FROM news WHERE parent_id=$parent_id AND url='$url' AND is_category=0 LIMIT 1");
                if ($article) {
                    $result['item'] = $article;
                    $result['labels'][] = $article['header'];
                } elseif ($category) {
                    $result['item'] = $category;
                    $result['labels'][] = $category['header'];
                } else {
                    $result['item'] = false;
                }
            } else {
                if ($category) {
                    $parent_id = $category['id'];
                    $result['labels'][] = $category['header'];
                } else {
                    $result['item'] = false;
                    break;
                }
            }
        }
        return $result;
    }

    // получить полный URL элемента по его id
    public function get_full_url($id)
    {
        $url = array();
        while ($id > 0) {
            $item = $this->get($id);
            if (!empty($item)) {
                $url[] = $item['url'];
                $id = $item['parent_id'];
            } else {
                return '';
            }
        }
        return '/'.implode('/', array_reverse($url));
    }

    // найти эл-ты с заданным url у данного родителя (используется в контроллере как проверка чтобы не возникали конфликтующие URL)
    public function find_conflict_id($url, $parent_id)
    {
        $r = $this->dbh->row("SELECT id FROM news WHERE parent_id=$parent_id AND url='$url'");
        return $r ? $r['id'] : 0;
    }



    // получить список id всех дочерних категорий (рекурсивно)
    protected function get_child_categories_id_recursively($parent_id)
    {
        $result = array();
        $child_categories = $this->get_child_categories($parent_id);
        foreach ($child_categories as $child_category) {
            $result[] = $child_category['id'];
            $inner_ids = $this->get_child_categories_id_recursively($child_category['id']);
            foreach ($inner_ids as $id) $result[] = $id;
        }
        return $result; 
    }
    // получить список доступных родителей (чтобы можно было переместить категорию не образовав замкнутый цикл наследования)
    public function get_available_parents($item)
    {
        if ($item['id'] == 0 || $item['is_category'] == 0) {
            return $this->dbh->query("SELECT * FROM news WHERE is_category=1");
        } else {
            $not_available = $this->get_child_categories_id_recursively($item['id']);
            if (!empty($not_available)) {
                $not_available[] = $item['id'];
                return $this->dbh->query("SELECT * FROM news WHERE is_category=1 AND id NOT IN (".implode(',', $not_available).")");
            } else {
                return $this->dbh->query("SELECT * FROM news WHERE is_category=1 AND id!=".$item['id']);
            }
        }
    }



    // скорректировать дату публикации потомков (при проходе в глубину дерева даты публикации не должны уменьшаться. Нельзя публиковать новость раньше, чем категорию, в которой она находится)
    public function adjust_childs_date_publish($category)
    {
        $childs = $this->dbh->query("SELECT * FROM news WHERE parent_id=$category[id]");
        foreach ($childs as $child) {
            if ($child['date_publish'] < $category['date_publish']) {
                $this->dbh->exec("UPDATE news SET date_publish=$category[date_publish] WHERE id=$child[id]");
                $child['date_publish'] = $category['date_publish'];
                if ($child['is_category'] == 1) $this->adjust_childs_date_publish($child);
            }
        }
    }
}