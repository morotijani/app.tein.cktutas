<?php 

	class News {
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

		public function allNews($conn) {
			$query = "
		        SELECT *, tein_news.id AS news_id FROM tein_news 
		        INNER JOIN tein_category 
		        ON tein_category.id = tein_news.news_category 
		        INNER JOIN tein_admin 
		        ON tein_admin.admin_id = tein_news.news_created_by
		        ORDER BY tein_news.id DESC 
		    ";
		    $statement = $conn->prepare($query);
		    $statement->execute();
		    $news = $statement->fetchAll();
		    if ($statement->rowCount() > 0) {
		    	// code...
			    foreach ($news as $new) {
	                $this->output .= "
	                	<tr>
	                		<td>" . $this->i . "</td>
		                    <td>" . $new['news_title'] . "</td>
		                    <td>" . ucwords($new['category']) . "</td>
		                    <td>" . $new['news_views'] . "</td>
		                    <td>" . pretty_date($new['createdAt']) . "</td>
		                    <td>" . ucwords($new['admin_fullname']) . "</td>
		                    <td>
		                    	<a class='badge bg-" . (($new['news_featured'] == 1) ? 'secondary' : 'primary') . " text-decoration-none' href='" . PROOT . 'blog/add/featured/' . $new['news_id'] . '/' . (($new['news_featured'] == 0) ? 1 : 2) . "'>" . (($new['news_featured'] == 1) ? 'featured' : '+ featured') . "</a>
		                    </td>
		                    <td>
		                        <a class='badge bg-primary text-decoration-none' href='javascript:;' data-bs-toggle='modal' data-bs-target='#viewModal" . $this->i . "'>View</a>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . "blog/add/edit_news/" . $new['news_id'] . "'>Edit</a>

		                        <!-- VIEW DETAILS MODAL -->
								<div class='modal fade' id='viewModal" . $this->i . "' tabindex='-1' aria-labelledby='viewModalLabel' aria-hidden='true' data-bs-backdrop='static' data-bs-keyboard='false'>
								  	<div class='modal-dialog modal-dialog-centered'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-header'>
								    			<h1 class='modal-title fs-5' id='viewModalLabel'>" . $new['news_title'] . "</h1>
        										<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
								    		</div>
								    		<img class='img-fluid' src='" . PROOT . $new['news_media'] ."' />
								    		<div class='modal-body'>
								    			<span class='badge bg-info'>" . ucwords($new['category']) . "</span>
								    			<br>
								      			<p>" . nl2br($new['news_content']) . "</p>
								      			<br>
								      			<small class='text-secondary'>
								      				Created By; " . ucwords($new['admin_fullname']) . " <br>
								      				Add On; " . pretty_date($new['createdAt']) . " <br>
								      				Views; " . $new['news_views'] . " <br>
								      			</small>
								      			<br>
								        		<button type='button' class='btn btn-sm btn-secondary rounded-0' data-bs-dismiss='modal'>Close</button>
								        		<a href='javascript:;' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "' class='btn btn-sm btn-outline-danger rounded-0'>Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>

								<!-- DELETE MODAL -->
								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='subscribeModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . "blog/add/delete/" . $new['news_id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>
		                    </td>
		                </tr>
		             ";
	            	$this->i++;
			    }
		    } else {
		    	$this->output = "
		    		<tr>
		    			<td colspan='3'>No data found!</td>
		    		</tr>
		    	";
		    }
		    return $this->output;
		}

		private function get_number_of_featured($conn) {
			$query = " 
				SELECT * FROM tein_news 
				WHERE news_featured = ? 
			";
			$statement = $conn->prepare($query);
			$statement->execute([1]);

			return $statement->rowCount();
		}

		public function featuredNews($conn, $feature, $id) {
			$featured = 0;
			if ($feature != 0) {
				$featured = $this->get_number_of_featured($conn);
			}
			$news = $this->findNews($conn, $id);
			if ($featured < 3) {
				if ($news > 0) {
					// code...
			        $query = "
			        	UPDATE tein_news 
			        	SET news_featured = ?
			        	WHERE id = ?
			        ";
			        $statement = $conn->prepare($query);
			        $result = $statement->execute([$feature, $id]);
			        return $result;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function deleteNews($conn, $id) {
	        $query = "
	        	UPDATE tein_category 
	        	SET news_status = ?
	        	WHERE id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $result = $statement->execute([1, $id]);
	        return $result;
		}


		public function fetchNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_status = ? 
				ORDER BY tein_news.createdAt ASC
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			$rows = $statement->fetchAll();

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
					          	<div class="mb-1 text-body-secondary">Nov 11</div>
					          	<p class="mb-auto">' . substr($row['news_content'], 0, 90) . ' ...</p>
					          	<a href="' . PROOT . 'news/' . $row["news_id"] . '" class="icon-link gap-1 icon-link-hover stretched-link">
					            	Continue reading
					            	<svg class="bi"><use xlink:href="#chevron-right"/></svg>
					          	</a>
					        </div>
					    </div>
					</div>
				';
			}

			return $this->output;
		}
		
		public function fetchFeaturedNews($conn) {
			
		}


	}

