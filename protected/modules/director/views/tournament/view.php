<?php
	$this->breadcrumbs=array(
		'Director' => array('//director'),
		'Tournaments'=>array('index'),
		'View'
	);

	$this->menu=array(
		array('label' => 'Actions'),
		array('label'=>'List Tournaments','url'=>array('index'), 'icon' => 'list'),
		array('label'=>'Create Tournament','url'=>array('create'), 'icon' => 'plus'),
		array('label'=>'Update Tournament','url'=>array('update','id'=>$model->id), 'icon' => 'pencil'),
		array('label'=>'Tournament Players','url'=>array('players', 'id' => $model->id), 'icon' => 'user'),
	);
	$this->page_header = "Tournament - " . $model->date;
?>

<?php
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			'date',
			'participants',
			array(
				'name' => 'entry_fee',
				'label' => 'Entry Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->entry_fee, 'USD')
			),
			array(
				'name' => 'bar_match',
				'label' => 'Bar Match',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->bar_match, 'USD')
			),
			array(
				'name' => 'xman',
				'label' => 'Xman Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->xman, 'USD')
			),
			array(
				'name' => 'auto_generate_teams',
				'label' => 'Auto Generate Teams',
				'value' => ($model->auto_generate_teams) ? "Yes" : "No"
			),
			array(
				'name' => 'high_dart',
				'label' => 'High Dart',
				'value' => ($model->high_dart) ? "Yes" : "No"
			),
			array(
				'name' => 'high_out',
				'label' => 'High Out',
				'value' => ($model->high_out) ? "Yes" : "No"
			),
			array(
				'name' => 'mystery_out',
				'label' => 'Mystery Out',
				'value' => ($model->mystery_out) ? "Yes" : "No"
			),
			array(
				'name' => 'honey_pot',
				'label' => 'Honey Pot',
				'value' => ($model->honey_pot) ? "Yes" : "No"
			),
			array(
				'name' => 'high_dart_fee',
				'label' => 'High Dart Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->high_dart_fee, 'USD')
			),
			array(
				'name' => 'high_out_fee',
				'label' => 'High Out Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->high_out_fee, 'USD')
			),
			array(
				'name' => 'mystery_out_fee',
				'label' => 'Mystery Out Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->mystery_out_fee, 'USD')
			),
			array(
				'name' => 'honey_pot_fee',
				'label' => 'Honey Pot Fee',
				'value' => Yii::app()->numberFormatter->formatCurrency($model->honey_pot_fee, 'USD'),
				'visible' => $model->honey_pot
			),
			array(
				'name' => 'creator',
				'label' => 'Tournament Director',
				'value' => $model->creator
			),
		),
	));
?>

<h3>Participants</h3>

<table class="table table-condensed">
<thead>
	<tr>
		<th>Name</th>
		<th>Chip Pulled</th>
		<th>High Dart</th>
		<th>High Out</th>
		<th>Mystery Out</th>
		<?php if($model->honey_pot): ?>
		<th>Honey Pot</th>
		<?php endif; ?>
		<th>Entry Fee</th>
	</tr>
</thead>
<tbody>
	<?php foreach($model->players as $tournament_player): ?>
		<tr>
			<td><?php echo $tournament_player->player->getFullName(true); ?></td>
			<td><?php echo $tournament_player->chip_pulled; ?></td>
			<td><?php echo ($tournament_player->high_dart)  ? "Y" : "N"; ?></td>
			<td><?php echo ($tournament_player->high_out)  ? "Y" : "N"; ?></td>
			<td><?php echo ($tournament_player->mystery_out)  ? "Y" : "N"; ?></td>
			<?php if($model->honey_pot): ?>
			<td><?php echo ($tournament_player->honey_pot)  ? "Y" : "N"; ?></td>
			<?php endif; ?>
			<td><?php echo Yii::app()->numberFormatter->formatCurrency($tournament_player->entry_fee, 'USD'); ?></td>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>

<?php $this->beginClip('sidebar'); ?>
    <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.tournament_quick_view'); ?>
    <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.tournament_payouts'); ?>
<?php $this->endClip(); ?>

<?php $this->beginClip('javascript'); ?>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/tournament.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/player.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/master_vm.js"></script>
    <script type="text/javascript">
        window.REGISTERED_PLAYERS = <?php echo $registered_players; ?>;
        $(function(){
            window.MASTERVM = new MasterVM(<?php echo $model->toJSON(); ?>);
            MASTERVM.setPlayers();

            ko.applyBindings(window.MASTERVM);
        });
    </script>
<?php $this->endClip(); ?>
