<?php 

	class News {
		private $i = 1;
		private $output = '';
		private $output_featured = '';
		private $output_onefeatured = '';
		private $output_single = '';
		private $output_subscribers = '';
		private $output_poupular = '';
		
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
		        WHERE tein_news.news_status = ?
		        ORDER BY tein_news.id DESC 
		    ";
		    $statement = $conn->prepare($query);
		    $statement->execute([0]);
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
		                    	<a class='badge bg-" . (($new['news_featured'] == 1) ? 'secondary' : 'primary') . " text-decoration-none' href='" . PROOT . '.in/blog/add/featured/' . $new['news_id'] . '/' . (($new['news_featured'] == 0) ? 1 : 2) . "'>" . (($new['news_featured'] == 1) ? 'featured' : '+ featured') . "</a>
		                    </td>
		                    <td>
		                        <a class='badge bg-primary text-decoration-none' href='javascript:;' data-bs-toggle='modal' data-bs-target='#viewModal" . $this->i . "'>View</a>
		                        <a href='javascript:;' class='badge bg-danger text-decoration-none' data-bs-toggle='modal' data-bs-target='#deleteModal" . $this->i . "'>Delete</a>
		                        <a class='badge bg-secondary text-decoration-none' href='" . PROOT . ".in/blog/add/edit_news/" . $new['news_id'] . "'>Edit</a>

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
								<div class='modal fade' id='deleteModal" . $this->i . "' tabindex='-1' aria-labelledby='newsModalLabel' aria-hidden='true'>
								  	<div class='modal-dialog modal-dialog-centered modal-sm'>
								    	<div class='modal-content' style='background-color: rgb(51, 51, 51)'>
								    		<div class='modal-body'>
								      			<p>When you delete this categoy, all news and details under it will be deleted as well.</p>
								        		<button type='button' class='btn btn-sm btn-secondary' data-bs-dismiss='modal'>Close</button>
								        		<a href='" . PROOT . ".in/blog/add/delete/" . $new['news_id'] . "' class='btn btn-sm btn-outline-secondary'>Confirm Delete.</a>
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

		public function deleteNewsMedia($conn, $id, $image) {
	        $mediaLocation = BASEURL . $image;
	        $delete = unlink($mediaLocation);
	        unset($image);

	        if ($delete) {
		        $update = "
		            UPDATE tein_news 
		            SET news_media = ? 
		            WHERE id = ?
		        ";
		        $statement = $conn->prepare($update);
		        $result = $statement->execute(['', $id]);
		        return $result;
		    } else {
		    	return false;
		    }
		}

		// get number of featured
		private function get_number_of_featured($conn) {
			$query = " 
				SELECT * FROM tein_news 
				WHERE news_featured = ? 
			";
			$statement = $conn->prepare($query);
			$statement->execute([1]);

			return $statement->rowCount();
		}

		// set featured or un featured
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

		// delete news by setting status to 1
		public function deleteNews($conn, $id) {
	        $query = "
	        	UPDATE tein_news 
	        	SET news_status = ?
	        	WHERE id = ?
	        ";
	        $statement = $conn->prepare($query);
	        $result = $statement->execute([1, $id]);
	        return $result;
		}

		// fetch all news except featured
		public function fetchNews($conn, $offset, $per_page) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC 
				LIMIT {$offset}, {$per_page}
			";
			$statement = $conn->prepare($query);
			$statement->execute([0, 0]);
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

			return $this->output;
		}
		
		// fetch the 2 featured news
		public function fetchFeaturedNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt ASC 
				LIMIT 2
			";
			$statement = $conn->prepare($query);
			$statement->execute([1, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {
				$this->output_featured .= '
					<div class="col-md-6">
				      	<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
				        	<div class="col p-4 d-flex flex-column position-static">
				          		<strong class="d-inline-block mb-2 text-primary-emphasis">' . ucwords($row["category"]) . '</strong>
				          		<h3 class="mb-0">' . ucwords($row["news_title"]) . '</h3>
				          		<div class="mb-1 text-body-secondary">' . pretty_month_and_day($row["ca"]) . '</div>
				          		<p class="card-text mb-auto">' . substr($row['news_content'], 0, 85) . ' ...</p>
				          		<a href="' . PROOT . 'view/' . $row["news_url"] . '" class="icon-link gap-1 icon-link-hover stretched-link">
				            		Continue reading
				            		<svg class="bi"><use xlink:href="#chevron-right"/></svg>
				          		</a>
				        	</div>
				        	<div class="col-auto d-none d-lg-block">
				        		<img src="' . PROOT . $row["news_media"]. '" class="bd-placeholder-img"width="200" height="250" style="object-fit: cover; object-position: center;">
				        	</div>
				      	</div>
				    </div>
				';
			}
			return $this->output_featured;
		}

		// get main or one feature post for the news
		public function fetch_oneFeaturedNews($conn) {
			$query = "
				SELECT *, tein_news.id AS news_id FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category
				WHERE tein_news.news_featured = ?
				AND tein_news.news_status = ? 
				ORDER BY tein_news.createdAt DESC 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([1, 0]);
			$rows = $statement->fetchAll();

			foreach ($rows as $row) {
				$this->output_onefeatured .= '
					<div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background-image: url(' . PROOT . $row["news_media"].'); background-position: center; background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">
			            <div class="col-lg-6 px-0">
			                <h1 class="display-4 fst-italic">' . ucwords($row["news_title"]) . '</h1>
			                <p class="lead my-3">' . substr($row['news_content'], 0, 115) . ' ...</p>
			                <p class="lead mb-0"><a href="' . PROOT . 'view/' . $row["news_url"] . '" class="text-body-emphasis fw-bold">Continue reading...</a></p>
			            </div>
			        </div>
				';
			}
			return $this->output_onefeatured;
		}

		// single view for news
		public function singleView($conn, $newsUrl) {
			$query = "
				SELECT *, tein_news.id AS news_id, tein_news.createdAt AS ca FROM tein_news 
				INNER JOIN tein_category 
				ON tein_category.id = tein_news.news_category 
				INNER JOIN tein_admin 
				ON tein_admin.admin_id = tein_news.news_created_by 
				WHERE tein_news.news_url = ?
				AND tein_news.news_status = ? 
				LIMIT 1
			";
			$statement = $conn->prepare($query);
			$statement->execute([$newsUrl, 0]);
			$row = $statement->fetchAll();
			//dnd($row);
			if ($statement->rowCount() > 0) {
				return '
					<article class="blog-post">
				        <h2 class="display-5 link-body-emphasis mb-1">' . ucwords($row[0]["news_title"]) . '</h2>
				        <p class="blog-post-meta">' . pretty_date_notime($row[0]['ca']) . ' by <a href="javascript:;">' . ucwords($row[0]['admin_fullname']) . '</a> . ' . $row[0]["news_views"] . ' view' . (($row[0]["news_views"] > 1) ? 's' : '') . '</p>
				        <img src="' . PROOT . $row[0]["news_media"] .'" class="img-fluid">
				        <p class="mt-4">' . nl2br($row[0]['news_content']) . '</p>
				    </article>
				';
			} else {
				return false;
			}
		}

		//
		public function updateViews($conn, $newsUrl) {
			$query = "
	        	UPDATE tein_news 
	        	SET news_views = news_views + 1
	        	WHERE news_url = ?
	        ";
	        $statement = $conn->prepare($query);
	        $statement->execute([$newsUrl]);
		}


		// popular post
		public function get_popular_post($conn) {}

		// News subscriber
		public function addSubscriber($conn, $email) {
			// check if email already exist
			$sql = "
				SELECT * FROM tein_subscribers 
				WHERE subscriber_email = ? 
			";
			$statement = $conn->prepare($sql);
			$statement->execute([$email]);

			if ($statement->rowCount() > 0) {
				return 'This email has already been used to subscribed.';
			} else {
				$query = "
					INSERT INTO tein_subscribers (subscriber_email) 
					VALUES (?)
				";
				$statement = $conn->prepare($query);
				$result = $statement->execute([$email]);
				if (isset($result)) {
					return 'You have successfully subscribed for daily news update.';
				} else {
					return false;
				}
			}
		}

		// all subscribers
		public function allSubscribers($conn) {
			$query = "
				SELECT * FROM tein_subscribers 
				ORDER BY id DESC
			";
			$statement = $conn->prepare($query);
			$statement->execute();
			$rows = $statement->fetchAll();
			$count = $statement->rowCount();

			if ($count > 0) {
				foreach ($rows as $row) {
					$this->output_subscribers .= '
						<tr>
							<td>' . $this->i . '</td>
							<td>' . $row['subscriber_email'] . '</td>
							<td>' . pretty_date_notime($row['createdAt']) . '</td>
							<td>
								<a href="javascript:;" class="badge bg-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteSubscriberModal' . $this->i . '">Delete</a>
								<!-- DELETE MODAL -->
								<div class="modal fade" id="deleteSubscriberModal' . $this->i . '" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-dialog-centered modal-sm">
								    	<div class="modal-content" style="background-color: rgb(51, 51, 51);"">
								    		<div class="modal-body">
								      			<p>When you delete this subscriber, this subscriber will no longer be able to receive daily updates on news.</p>
								        		<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
								        		<a href=' . PROOT . ".in/blog/subscribers/delete_subscriber/" . $row['id'] . ' class="btn btn-sm btn-outline-secondary">Confirm Delete.</a>
								      		</div>
								    	</div>
								 	</div>
								</div>
							</td>
						</tr>
					';
					$this->i++;
				}
			} else {
				$this->output_subscribers .= '
					<tr>
						<td colspan="4">No data found</td>
					</tr>
				';
			}

			return $this->output_subscribers;
		}

		public function deleteSubscriber($conn, $id) {
			$query = "
				DELETE FROM tein_subscribers 
				WHERE id = ? 
			";
			$statement = $conn->prepare($query);
			$result = $statement->execute([$id]);

			if ($result) {
				// code...
				return true;
			} else {
				return false;
			}
		}

		// fetch popular news
		public function popularNews($conn) {
			$thisMonth = date('m');
			$query = "
				SELECT * FROM tein_news 
				WHERE news_views > ? 
				AND MONTH(createdAt) = ? 
				ORDER BY news_views DESC
				LIMIT 4 
			";
			$statement = $conn->prepare($query);
			$statement->execute([10, $thisMonth]);
			$rows = $statement->fetchAll();
			// dnd($rows);
			if ($statement->rowCount() > 0) {
				// code...
				foreach ($rows as $row) {
					// code...
					$this->output_poupular .= '
						<li>
	                        <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="'. PROOT .'view/' . $row['news_url'] . '">
	                        <img src="' . PROOT . $row['news_media'] . '" class="bd-placeholder-img" width="100%" height="96" style="object-position: center; object-fit: cover;">
	                            <div class="col-lg-8">
	                                <h6 class="mb-0">' . substr($row["news_title"], 0, 49) . '</h6>
	                                <small class="text-body-secondary">' . pretty_date_notime($row["createdAt"]) . ' . ' . $row['news_views'] . ' views</small>
	                            </div>
	                        </a>
	                    </li>
					';
				}
			} else {

			}
			return $this->output_poupular;
		}

	}

