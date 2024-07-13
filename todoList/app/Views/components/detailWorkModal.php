<?php

use App\Controllers\WorkController;

$workController = new WorkController();
$statusOptions = $workController->getStatusOptions();
?>

<div id="detail_work_modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="detail-modal-title">Work </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="work_detail_form">
					<div class="form-group">
						<label for="detail_work_name">Work name:</label>
						<input type="text" class="form-control" id="detail_work_name">
					</div>
					<div class="form-group">
						<label for="detail_work_status">Status: </label>
						<select name="work_status" id="detail_work_status" class="form-control">
							<?php foreach ($statusOptions as $option) : ?>
								<option value="<?= $option ?>"><?= $option ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="detail_work_start_date">Work start:</label>
						<input type="date" class="form-control" id="detail_work_start_date">
					</div>
					<div class="form-group">
						<label for="detail_work_end_date">Work end:</label>
						<input type="date" class="form-control" id="detail_work_end_date">
					</div>
					<input type="hidden" id="detail_work_id">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="update_work">Update</button>
				<button type="button" class="btn btn-danger" id="remove_work">Remove</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#update_work').on('click', function() {
			var workId = $('#detail_work_id').val();
			var data = {
				work_name: $('#detail_work_name').val(),
				work_status: $('#detail_work_status').val(),
				work_start_date: $('#detail_work_start_date').val(),
				work_end_date: $('#detail_work_end_date').val()
			};

			$.ajax({
				url: '/works/' + workId,
				type: 'PATCH',
				contentType: 'application/json',
				data: JSON.stringify(data),
				success: function(response) {
					$('#detail_work_modal').modal('hide');
					location.reload()
				},
				error: function(error) {
					console.error('Error updating work:', error);
				}
			});
		});

		$('#remove_work').on('click', function() {
			var workId = $('#detail_work_id').val();

			$.ajax({
				url: '/works/' + workId,
				type: 'DELETE',
				success: function(response) {
					$('#detail_work_modal').modal('hide');
					location.reload()
				},
				error: function(error) {
					console.error('Error removing work:', error);
				}
			});
		});
	});
</script>