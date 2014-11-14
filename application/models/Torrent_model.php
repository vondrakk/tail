<?php

class Torrent_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
        public function get_torrents($pagestart=0) {
			$query = $this->db->query("SELECT a.torrent_hash,a.name,a.size,a.createdt,c.name as 'category',b.complete,b.downloading,b.downloaded,b.transferred FROM `torrents` a, tracking_data b, categories c where a.torrent_hash=b.FK_torrent_hash and a.FK_category_id=c.category_id group by a.torrent_hash order by b.complete desc limit $pagestart,20");
			return $query->result_array();
		}
		
		public function get_torrent_count() {
			$query = $this->db->query("SELECT count(0) as num from torrents");
			$rows= $query->result_array();
			return $rows[0]["num"];
		}
}
