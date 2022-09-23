<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<div class="home-tab">
					<?php if(validation_errors()){ ?>
						<div class="alert alert-danger" role="alert">
							<?php echo validation_errors(); ?>
						</div>
					<?php }?>
					<div class="tab-content tab-content-basic">
						<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
							<div class="row">
								<div class="col-lg-12 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 grid-margin stretch-card">
											<div class="card card-rounded">
												<div class="card-body">
													<h4 class="card-title">School Information Form</h4>
													<p class="card-description">
														Edit School
													</p>
													<form class="forms-sample" method="post" action="<?php echo site_url('School/editschoolinfo?for='.$schoolinfo->id);?>">
														<div class="form-group">
															<label for="schoolname">Name</label>
															<input type="text" class="form-control" id="schoolname" name="schoolname" placeholder="School Name" value="<?php echo $schoolinfo->name;?>">
														</div>
														<div class="form-group">
															<label for="exampleTextarea1">Location</label>
															<textarea class="form-control" id="exampleTextarea1" rows="4" name="location"><?php echo $schoolinfo->location;?></textarea>
														</div>
														<button type="submit" class="btn btn-primary me-2">Submit</button>
														<a href="<?php echo site_url('School/schoolinfo');?>" class="btn btn-light">Cancel</a>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- content-wrapper ends -->