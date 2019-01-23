<?php

namespace core\traits;
use PDO;

trait Page {
	
	private $pages;
	
	public function getPage($login, $role) {
		$p = $this->db->query("SELECT 
			p.id,
			p.page,
			p.href
			FROM page p
			INNER JOIN (SELECT priority FROM role WHERE name = '{$role}') t1 ON t1.priority <= p.priority
			UNION
			SELECT
			p.id,
			p.page,
			p.href
			FROM page p
			LEFT JOIN(SELECT login, COUNT(enable) AS count FROM expert_work WHERE enable = 1) t2 ON t2.login = '{$login}'
			WHERE p.priority = 2 AND t2.login IS NOT NULL

			");
		while ($row = $p->fetch(PDO::FETCH_ASSOC)) {
			$this->pages[] = $row;
		}
		return $this->pages;
	}
}

?>