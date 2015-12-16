<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
        'Tournaments'=>array('index'),
        'Teams',
    );

    $this->menu=array(
        array('label'=>'Tournament Players','url'=>array('players', 'id' => $model->id), 'icon' => 'user'),
        array('label'=>'List Tournaments','url'=>array('index'), 'icon' => 'list'),
        array('label'=>'Edit Tournament','url'=>array('update', 'id' => $model->id), 'icon' => 'pencil'),
    );
    $this->page_header = 'Tournament Teams - ' . $model->date;
?>

<?php if($model->started): ?>
    <div class="alert alert-warning alert-block">
        The tournament has already started.  You can no longer make any changes.
    </div>
<?php else: ?>
    <div data-bind="visible: $root.tournament.teams_selected">
        <button id="redraw_teams" class="btn btn-danger pull-right"><i class="icon icon-exclamation"></i> Redraw Teams <i class="icon icon-exclamation"></i></button>
        <h3>Teams</h3>
        <table class="table table-condensed">
        <thead>
            <tr>
                <th>Position</th>
                <th>Team</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($teams as $position => $players): ?>
            <tr>
                <td><?php echo $position; ?></td>
                <td><?php echo implode(' & ', $players); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>

    <div data-bind="visible: !$root.tournament.teams_selected()">
        <h3>Players</h3>
        <div class="row">
            <div class="span4">
                <table class="table table-condensed player_add">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Chip Pulled</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: $root.split_players().top">
                    <tr>
                        <td data-bind="text: name, css: {warning: xman}"></td>
                        <td data-bind="css: {warning: xman}"><input type="text" class="input-mini position" data-bind="value: chip_pulled, event: {blur: $root.validateChip}" /></td>
                    </tr>
                </tbody>
                </table>
            </div>

            <div class="span5">
                <table class="table table-condensed player_add">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Chip Pulled</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: $root.split_players().bottom">
                    <tr>
                        <td data-bind="text: name, css: {warning: xman}"></td>
                        <td data-bind="css: {warning: xman}"><input type="text" class="input-mini position" data-bind="value: chip_pulled, event: {blur: $root.validateChip}" /></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($model->teams_selected()): ?>
        <form method="post" action="<?php echo $this->createUrl('//director/tournament/starttournament', array('id' => $model->id)); ?>">
            <input type="hidden" name="Teams[info]" value='start_tournamnet' />
            <div class="form-actions">
                <button class="btn btn-primary">Start Tournament</button>
            </div>
        </form>
    <?php else: ?>
    <form method="post">
        <input type="hidden" name="Teams[info]" data-bind="value: ko.toJSON($root)" />
        <div class="form-actions">
            <button class="btn btn-primary">Save Teams</button>
        </div>
    </form>
    <?php endif; ?>


    <pre data-bind="text: ko.toJSON($root, null, 2)"></pre>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'warningModal')); ?>

    <div class="modal-body">
        <p>Are you sure you want to redraw teams?</p>
        <p>All the players will need to redraw their chips and will be really pissed at you for making them do it twice.</p>
        <p>Take a second and make sure this is what you want to do.</p>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'danger',
            'label'=>'Redraw Teams',
            'url'=>'#',
            'htmlOptions'=>array(
                'data-bind' => 'click: $root.redrawTeams'
            ),
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Cancel',
            'url'=>'#',
            'htmlOptions'=>array(
                'data-dismiss'=>'modal'
            ),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php endif; ?>

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

            var selected_chips = [];

            $("#redraw_teams").on('click', function(evt){
                evt.preventDefault();
                $("#warningModal").modal('show');
            });
        });
    </script>
<?php $this->endClip(); ?>
