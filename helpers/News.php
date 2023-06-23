<?php 

	class News {
		private $i = 1;
		private $output = '';
		
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
								    			<br>
								      			<p>" . nl2br($new['news_content']) . "</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='javascript:;' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
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

	}

