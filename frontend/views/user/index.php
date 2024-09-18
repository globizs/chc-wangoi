<?php

use yii\helpers\Html;

$this->title = 'User Management';
?>

<p>
	<?= Html::a('Add User', ['create'], ['class' => 'btn btn-success openModal', 'size' => 'lg', 'header' => 'Add User']) ?>
</p>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>Sl</th><th>Username</th><th>Status</th><th></th>
				</tr>
				<?php foreach ($users as $sl => $user) { ?>
					<tr>
						<td><?= $sl + 1 ?></td>
						<td><?= $user['username'] ?></td>
						<td><?= $user['status'] == 10 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' ?></td>
						<td>
							<?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $user['id']], ['class' => 'openModal', 'size' => 'sm', 'header' => 'Edit User', 'title' => 'Edit User']) ?>&nbsp;&nbsp;
							<?= 1 || $user['id'] == 1 ? '' : Html::a('<i class="fas fa-user-lock"></i>', ['permission', 'id' => $user['id']], ['class' => 'openModal', 'header' => 'Assign Permissions', 'size' => 'lg', 'title' => 'User Permissions']) ?>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
