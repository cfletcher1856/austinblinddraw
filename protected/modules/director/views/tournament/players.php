<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
        'Tournaments'=>array('index'),
        'Players',
    );

    $this->menu=array(
        array('label'=>'Tournament Teams','url'=>array('teams', 'id' => $model->id), 'icon' => 'users'),
        array('label'=>'List Tournaments','url'=>array('index'), 'icon' => 'list'),
        array('label'=>'Edit Tournament','url'=>array('update', 'id' => $model->id), 'icon' => 'pencil'),
    );
    $this->page_header = 'Tournament Players - ' . $model->date;
?>
<?php if($model->started): ?>
    <div class="alert alert-warning alert-block">
        The tournament has already started.  You can no longer make any changes.
    </div>
<?php else: ?>
    <form class="form-inline" data-bind="visible: !$root.teams_selected()">
        <?php
            $this->widget('bootstrap.widgets.TbTypeahead', array(
                'id' => 'player',
                'name' => 'player',
                'options' => array(
                    'source' => $players,
                    'items' => 5
                ),
            ));
        ?>
        <button class="btn" data-bind='click: addPlayer'><i class="icon icon-plus"></i> Add player</button>
    </form>

    <div class="alert alert-info alert-block" data-bind="visible: $root.teams_selected()">
        The teams have already been selected.  If new players need to be added go to the teams section and click the redraw button.
        <i class="icon icon-warning"></i> This will cause everyone to have to redraw their chip <i class="icon icon-warning"></i>
    </div>

    <table class="table table-condensed player_add">
    <thead>
        <tr>
            <th data-bind="visible: !$root.teams_selected()">&nbsp;</th>
            <th>Name</th>
            <th>High Dart</th>
            <th>High Out</th>
            <th>Mystery Out</th>
            <th data-bind="visible: $root.hasHoneyPot">Honey Pot</th>
            <th data-bind="visible: $root.hasHoneyPot">Female</th>
            <th data-bind="visible: $root.hasXman">X-Man</th>
            <th>$</th>
        </tr>
    </thead>
    <tbody data-bind="foreach: players">
        <tr data-bind="css: {warning: xman}">
            <td data-bind="visible: !$root.teams_selected()">
                <a href="javascript: void(0);" data-bind="click: $root.removePlayer" rel="tooltip" title="Remove Player">
                    <i class="icon icon-times"></i>
                </a>
            </td>
            <td data-bind="text: name"></td>
            <td>
                <input type="checkbox" data-bind="checked: high_dart, visible: !xman()" />
            </td>
            <td>
                <input type="checkbox" data-bind="checked: high_out, visible: !xman()" />
            </td>
            <td>
                <input type="checkbox" data-bind="checked: mystery_out, visible: !xman()" />
            </td>
            <td data-bind="visible: $root.hasHoneyPot">
                <input type="checkbox" data-bind="checked: honey_pot, visible: !xman()" />
            </td>
            <td data-bind="visible: $root.hasHoneyPot, text: is_female()"></td>
            <td data-bind="visible: $root.hasXman">
                <button data-bind="click: $root.addXman, visible: player_id() == $root.selected_xman()" class="btn btn-mini btn-success"><i class="icon icon-plus"></i></button>
                <i data-bind="visible: xman" class="icon icon-check"></i>
            </td>
            <td data-bind="text: entry_fee"></td>
        </tr>
    </tbody>
    </table>

    <form method="post">
        <input type="hidden" name="Tournament[info]" data-bind="value: ko.toJSON($root)" />
        <div class="form-actions">
            <button data-bind="visible: $root.hasXman() && !$root.xman(), click: $root.selectXman" class="btn btn-info">Select X-Man</button>
            <button class="btn btn-primary" data-bind="disable: $root.hasXman() && !$root.xman()">Save Players</button>
        </div>
    </form>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'addplayer_modal')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h4>Add Player</h4>
        </div>
        <div class="modal-body">
            <p>We could not find this player.  Would you like to add them to the database and tournament?</p>
            <p class="help-block">Fields with <span class="required">*</span> are required.</p>
            <div class="control-group ">
                <label class="control-label required" for="Player_name">Name <span class="required">*</span></label>
                <input class="span5" maxlength="250" name="Player[name]" id="Player_name" type="text" />
            </div>
            <div class="control-group ">
                <label class="control-label" for="Player_nickname">Nickname</label>
                    <input class="span5" maxlength="250" name="Player[nickname]" id="Player_nickname" type="text" />
                </div>
            <div class="control-group ">
                <label class="checkbox" for="Player_female">
                    <input name="Player[female]" id="Player_female" value="1" type="checkbox" />
                    Female
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button data-bind="click: $root.addplayertodbandtournament" class="btn btn-primary" type="button" name="yt0" id="yt0">Create</button>
        </div>
    <?php $this->endWidget(); ?>

    <pre data-bind="text: ko.toJSON($root, null, 2)"></pre>
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
        window.PLAYERS = <?php echo $playersJSON; ?>;
        window.REGISTERED_PLAYERS = <?php echo $registered_players; ?>;
        $(function(){
            window.MASTERVM = new MasterVM(<?php echo $model->toJSON(); ?>);
            MASTERVM.setPlayers();

            ko.applyBindings(window.MASTERVM);
        });
    </script>
<?php $this->endClip(); ?>
