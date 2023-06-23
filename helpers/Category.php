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
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . "blog/category/edit/" . $category['id'] . "'>Edit</a>
		                    </td>
		                    <td>" . ucwords($category['category']) . "</td>
		                    <td>" . pretty_date($category['createdAt']) . "</td>
		                    <td>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>

								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='subscribeModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . "blog/category/delete/" . $category['id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
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

	}

