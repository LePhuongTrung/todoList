<?php

use App\Controllers\WorkController;

$workController = new WorkController();
$statusOptions = $workController->getStatusOptions();
?>

<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<form id="work_form" action="/save-work" method="post">
				<div class="modal-header">
					<h5 class="modal-title" id="modalLabel">Add New Work</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="img-container">
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
									<label for="work_name">Work name</label>
									<input type="text" name="work_name" id="work_name" class="form-control" placeholder="Enter your work name">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label for="work_status">Status</label>
									<select name="work_status" id="work_status" class="form-control">
										<?php foreach ($statusOptions as $option) : ?>
											<option value="<?= $option ?>"><?= $option ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="work_start_date">Work start</label>
									<input type="date" name="work_start_date" id="work_start_date" class="form-control onlydatepicker" placeholder="Work start date">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="work_end_date">Work end</label>
									<input type="date" name="work_end_date" id="work_end_date" class="form-control" placeholder="Work end date">
								</div>
							</div>
						</div>
						<input type="hidden" name="work_id" id="work_id">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="modal_submit_button" class="btn btn-primary">Save Work</button>
				</div>
			</form>
		</div>
	</div>
</div>