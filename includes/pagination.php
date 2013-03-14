<?php

// This is a helper class to make paginating records easy.

class Pagination {
    
    public $current_page;
    public $per_page;
    public $total_count;
    public $order_by;
    
    public function __construct($page=1, $per_page=20, $total_count=0, $order_by=null) {
        $this->current_page = (int)$page;
        $this->per_page = (int)$per_page;
        $this->total_count = (int)$total_count;
        $this->order_by = (string)$order_by;
    }
    
    public function offset() {
        return ($this->current_page - 1) * $this->per_page;
    }
    
    public function total_pages() {
        return ceil($this->total_count/$this->per_page);
    }
    
    public function previous_page() {
        $previous_page = $this->current_page - 1;
        return $previous_page >= 1 ? $previous_page : false;
    }
    
    public function next_page() {
        $next_page = $this->current_page + 1;
        return $next_page <= $this->total_pages() ? $next_page : false;
    }
    
    public function display($url) {
        if($this->total_pages() <= 1)
            return;
        
        $html = "<div id=\"pagination\">";
        
        // previous page
        if($previous_page = $this->previous_page())
            $html .= "<a href=\"{$url}{$previous_page}\">&laquo Previous</a>";
            
        // page list
        for($i=1; $i <= $this->total_pages(); $i++) {
            if($i == $this->current_page) {
                $html .= " <span class=\"selected\">{$i}</span>";
            } else {
                $html .= " <a href=\"{$url}{$i}\">{$i}</a>";
            }
        }
        // next page
        if($next_page = $this->next_page())
            $html .= " <a href=\"{$url}{$next_page}\">Next &raquo</a>";
        $html .= "</div>";
        return $html;
    }
}