<?php 

	class Category {
		private $i = 1;
		private $output = '';
		
		public function listCategory($conn) {
			$query = "
				SELECT * FROM tein_category 
				WHERE category_trash = ? 
				ORDER BY category
			";
			$statement = $conn->prepare($query);
			$statement->execute([0]);
			return $statement->fetchAll();
		}

		public function allCategory($conn) {
			$query = "
		        SELECT * FROM tein_category 
		        ORDER BY category ASC 
		    ";
		    $statement = $conn->prepare($query);
		    $statement->execute();
		    $categories = $statement->fetchAll();
		    if ($statement->rowCount() > 0) {
		    	// code...
			    foreach ($categories as $category) {
	                $this->output .= "
	                	<tr>
		                    <td>
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . ".in/blog/category/edit_category/" . $category['id'] . "'>Edit</a>
		                    </td>
		                    <td>" . ucwords($category['category']) . "</td>
		                    <td>" . pretty_date($category['createdAt']) . "</td>
		                    <td>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>

								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='subscribeModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51);'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . ".in/blog/category/delete/" . $category['id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
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

		public function deleteCategory($conn, $id) {
	        $query = "
	        	DELETE FROM tein_category 
	        	WHERE id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $result = $statement->execute([$id]);
	        return $result;
		}


		// fetch all news base on category
		public function fetchCategoryNews($conn, $url) {
			$query = "
				SELECT *, tein_news.createdAt AS ca FROM tein_category 
				INNER JOIN tein_news 
				ON tein_news.news_category = tein_category.id
				WHERE tein_category.category_url = ? 
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute([$url, 0]);
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

