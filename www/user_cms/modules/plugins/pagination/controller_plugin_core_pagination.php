<?php
class controller_plugin_core_pagination extends plugin
{

    public function action_index()
    {
        $params = explode(',', $this->run_params);
        if (count($params) == 3) {
            $this->data['current_page'] = intval(trim(str_replace('&nbsp;', ' ', $params[0])));
            $this->data['pages_amount'] = intval(trim(str_replace('&nbsp;', ' ', $params[1])));
            $this->data['url_template'] = trim(str_replace('&nbsp;', ' ', $params[2]));

            $this->page['html'] = $this->load_view();
            return $this->page;
        } else {
            trigger_error('You must give three parameters (separated with colon): current page number, total pages number, url with placeholder (%u)', E_USER_WARNING);
        }
    }

}