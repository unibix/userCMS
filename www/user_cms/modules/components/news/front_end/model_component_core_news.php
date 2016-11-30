<?php 
class model_component_core_news extends model
{
    private $component = 'news';

    public function get($id)
    {
        if (is_numeric($id)) return $this->dbh->row("SELECT * FROM news WHERE id=$id");
    }

    public function fetch_childrens($parent_id, $offset, $limit)
    {
        if (is_numeric($parent_id) && is_numeric($offset) && is_numeric($limit)) {
            $today = time();
            return $this->dbh->query("SELECT * FROM news WHERE parent_id=$parent_id AND date_publish<$today ORDER BY date_publish DESC LIMIT $offset,$limit");
        }
    }

    public function count_childrens($parent_id)
    {
        if (is_numeric($parent_id)) {
            $today = time();
            $r = $this->dbh->row("SELECT COUNT(id) AS c FROM news WHERE parent_id=$parent_id  AND date_publish<$today");
            return $r ? $r['c'] : 0;
        }
    }

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
}