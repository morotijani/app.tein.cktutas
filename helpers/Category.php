<?php 

	class Category {
		private $i = 1;
		private $output = '';
		

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
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' onclick='(confirm(\"Order will be deleted!\") ? window.location = "\'" . PROOT . "blog/category/delete/" . $category['id'] . "'\" : '')'>Delete</a>
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

