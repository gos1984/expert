<?php

namespace core\traits;

use PDO;

trait Page
{

	private $pages;

	public function getPage()
	{
		$p = $this->db->query("SELECT
			p.id,
			p.page,
			p.href
			FROM page p
			WHERE CASE (SELECT role_id FROM access WHERE user_login = '{$this->user['login']}')
			WHEN 1 THEN p.id 
			WHEN 2 THEN p.id IN (4,6)
			WHEN 3 THEN p.id IN (4,5,6)
			END");
			while ($row = $p->fetch(PDO::FETCH_ASSOC)) {
				$this->pages[] = $row;
			}
			return $this->pages;
		}
	}

	?>