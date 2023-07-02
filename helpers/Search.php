<?php 

	class Search {
		private $i = 1;
		private $output = '';
		
		private function findNews($conn, $id) {
			$query = " 
				SELECT * FROM tein_news 
				WHERE id = ? 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([$id]);

			return $statement->rowCount();
		}

		// fetch all news base on category
		public function fetchSearchNews($conn, $q) {
			$query = "
				SELECT *, tein_news.createdAt AS ca FROM tein_category 
				INNER JOIN tein_news 
				ON tein_news.news_category = tein_category.id
				WHERE (tein_news.news_title LIKE '%" . $q . "%' 
								OR MONTH(tein_news.createdAt) = '" . $q . "') 
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			$rows = $statement->fetchAll();

			if ($statement->rowCount() > 0) {
				foreach ($rows as $row) {
					$this->output .= '

						<div class="col-sm-6 col-lg-6 mb-4">
							<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
						        <div class="col-auto d-none d-lg-block">
						        	<img src="' . PROOT . $row["news_media"]. '" class="img-fluid" width="100%" height="100%">
						        </div>
						        <div class="col p-4 d-flex flex-column position-static">
						          	<strong class="d-inline-block mb-2 text-success-emphasis">' . ucwords($row["category"]) . '</strong>
						          	<h3 class="mb-0">' . $row["news_title"] . '</h3>
						          	<div class="mb-1 text-body-secondary">' . pretty_month_and_day($row["ca"]) . '</div>
						          	<p class="mb-auto">' . substr($row['news_content'], 0, 90) . ' ...</p>
						          	<a href="' . PROOT . 'view/' . $row["news_url"] . '" class="icon-link gap-1 icon-link-hover stretched-link">
						            	Continue reading
						            	<svg class="bi"><use xlink:href="#chevron-right"/></svg>
						          	</a>
						        </div>
						    </div>
						</div>
					';
				}
			} else {
				return false;
			}
			return $this->output;
		}

	}

