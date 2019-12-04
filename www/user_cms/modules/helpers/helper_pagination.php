<?php
class helper_pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Показано с {start} по {end} из {total} (всего {pages} страниц)';
	public $text_first = '&laquo;';
	public $text_last = '&raquo;';
	public $text_next = 'Cледующая';
	public $text_prev = 'Предыдущая';
	public $style_links = 'links';
	public $style_results = 'results';
	 
	public function render() {
		$total = $this->total;
		
		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		
		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}
		
		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		
		if($num_pages > $this->num_links){//ссылки предыдущая и следующая показываем если страниц больше чем отображается (параметр $num_links)
			if ($page > 1) {
				$output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', 'page='.($page - 1), $this->url) . '">' . $this->text_prev . '</a></li>';
	    	}else{
	    		$output = '<li class="page-item disabled"><span class="page-link">'.$this->text_prev.'</span></li>';
	    	}
		}
		
		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}
			if ($start > 1) {
				$output .= ' <li class="page-item disabled"><span class="page-link"> .... </span></li>';
			}
			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .='<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
				} else {
					$output .= ' <li class="page-item"><a class="page-link" href="' . str_replace('{page}', 'page='.$i, $this->url) . '">' . $i . '</a></li> ';
				}	
			}
							
			if ($end < $num_pages) {
				$output .= ' <li class="page-item disabled"><span class="page-link"> .... </span></li>';
			}
		}
		
		if($num_pages > $this->num_links){
	   		if ($page < $num_pages) {
				$output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', 'page='.($page + 1), $this->url) . '">' . $this->text_next . '</a></li>';
			}else{
				$output .= '<li class="page-item disabled"><span class="page-link">'.$this->text_next.'</span></li>';
			}
		}
		
		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);
		
		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total, 
			$num_pages
		);	
		return ($output && $num_pages > 1? '<nav><ul class="pagination">' . $output . '</ul></nav>' : '');
	}
}
?>