<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
        'Matches',
    );

    $this->page_header = 'Tournaments';
?>
    <!-- pre>
        <?php print_r($matches); ?>
    </pre -->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#list" data-toggle="tab">List</a>
        </li>
        <li>
            <a href="#bracket" data-toggle="tab">Bracket</a>
        </li>
        <li>
            <a href="#extra" data-toggle="tab">High Darts / Outs</a>
        </li>
        <!-- li>
            <a href="#results" data-toggle="tab">Results</a>
        </li -->
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="list">
            <?php if(count($matches['winners']['open']) || count($matches['losers']['open'])): ?>
                <?php if(count($matches['winners']['open'])): ?>
                <h3>Winners Bracket</h3>
                <table class="table table-condensed">
                <?php foreach($matches['winners']['open'] as $match): ?>
                <tr>
                    <td style="width: 550px">
                        <?php echo $match->get_match_display(); ?>
                    </td>
                    <td>
                        Round <?php echo $match->round; ?>
                    </td>
                    <td>
                        <button data-match-id="<?php echo $match->challonge_match_id; ?>" data-team-1="<?php echo $match->team_1; ?>" data-team-2="<?php echo $match->team_2; ?>" class="btn btn-mini btn-info pull-right results">Results</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </table>
                <?php endif; ?>

                <?php if(count($matches['losers']['open'])): ?>
                <h3>Losers Bracket</h3>
                <table class="table table-condensed">
                <?php foreach($matches['losers']['open'] as $match): ?>
                <tr>
                    <td style="width: 550px">
                        <?php echo $match->get_match_display(); ?>
                    </td>
                    <td>
                        Round <?php echo abs($match->round); ?>
                    </td>
                    <td>
                        <button data-match-id="<?php echo $match->challonge_match_id; ?>" data-team-1="<?php echo $match->team_1; ?>" data-team-2="<?php echo $match->team_2; ?>" class="btn btn-mini btn-info pull-right results">Results</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </table>
                <?php endif; ?>
                <h3>Completed Matches</h3>
            <?php else: ?>
                <h3>The tournament is over</h3>
                <p>Please review the bracket and make sure everything is correct.  If it is please finalize the tournament.  Once the tournamt is finalized no more changes can be made.</p>
                <a href="/director/tournament/finalizetournament/id/<?php echo $model->id; ?>" class="btn btn-success">Finalize Tournament</a>
            <?php endif; ?>
        </div>
        <div class="tab-pane" id="bracket">
            <img id="challonge_bracket" src="<?php echo $model->challonge_image; ?>" />
        </div>
        <div class="tab-pane" id="extra">
            <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Outs</th>
                    <th>High Dart</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                function highout_callback($hd){
                    return $hd->high_out;
                }
                foreach($model->getOrderedPlayerList() as $player): ?>
                <tr>
                    <td><?php echo $player->getFullName(); ?></td>
                    <td><?php
                            echo implode(', ', array_map("highout_callback", $player->getOuts($model->id)));
                    ?></td>
                    <td><?php echo $player->getHighDart($model->id); ?></td>
                    <td>
                        <a href="#" class="edit_outs_highdart" data-tournament-id="<?php echo $model->id; ?>" data-player-id="<?php echo $player->id; ?>">
                            <i class="icon icon-pencil"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        <!-- div class="tab-pane" id="results">
            <table class="table table-condensed">
            <?php //foreach($completed_matches as $match): ?>
                <tr>
                    <td style="width: 550px">
                        <?php //echo $match->get_match_display(); ?>
                    </td>
                    <td>
                        Round <?php //echo $match->round; ?>
                    </td>
                    <td>
                        <button data-match-id="<?php //echo $match->challonge_match_id; ?>" data-team-1="<?php //echo $match->team_1; ?>" data-team-2="<?php //echo $match->team_2; ?>" class="btn btn-mini btn-info pull-right results">Results</button>
                    </td>
                </tr>
            <?php //endforeach; ?>
            </table>
        </div -->
    </div>






<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'challonge_tournaments_modal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Match Details</h4>
</div>
<div class="modal-body">
    <div class="score-reporting">
        <form action="/director/tournament/matchresults/id/<?php echo $model->id; ?>" id="report_scores_form" method="post">
            <div class="winner-selection">
                <input id="winner_id" name="winner_id" type="hidden" />
                <input id="team_number" name="team_number" type="hidden" />
                <input id="match_id" name="match_id" type="hidden" />
                <div class="btn-group btn-block" data-toggle="buttons-radio" id="winner-btn-group" style="text-align: center">
                    <button class="btn btn-info winner-btn" data-team-number="1" data-value="" id="btn-p1" type="button"></button>
                    <button class="btn btn-info winner-btn" data-team-number="2" data-value="" id="btn-p2" type="button"></button>
                </div>
            </div>
            <hr />
            <table class="table table-condensed">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="2">Outs</th>
                    <th>High Dart</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: players">
                <tr>
                    <td data-bind="text: name"></td>
                    <td><input type="text" class="input-mini" data-bind="attr: {
                        name: 'Data[outs][game1][' + id + ']'
                    }" /></td>
                    <td><input type="text" class="input-mini" data-bind="attr: {
                        name: 'Data[outs][game2][' + id + ']'
                    }" /></td>
                    <td><input type="text" class="input-mini" data-bind="attr: {
                        name: 'Data[high_dart][' + id + ']'
                    }" /></td>
                </tr>
            </tbody>
            </table>
            <div class="modal-footer">
                <input class="btn btn-primary" data-disable-with="Saving..." id="score_submit_button" name="commit" type="submit" value="Submit Scores" />
            </div>
        </form>
    </div>
</div>
<?php $this->endWidget(); ?>


<?php $this->beginClip('javascript'); ?>
    <script type="text/javascript">
        $(function(){
            var Player = function(player){
                var self = this;
                self.id = player.id;
                self.name = player.name;

                return self;
            };

            var StatsVM = function(){
                var self = this;
                self.players = ko.observableArray();

                return self;
            };

            window.STATS = new StatsVM();

            ko.applyBindings(window.STATS);

            $(".winner-btn").on('click', function(evt){
                $("#winner_id").val($(this).data('value'));
                $("#team_number").val($(this).data('team-number'));
            })

            $("#score_submit_button").on('click', function(evt){
                evt.preventDefault();
                if(!$("#winner_id").val()){
                    alert("You need to select a winner");
                } else {
                    $("#report_scores_form").submit();
                }
            });

            $('.results').on('click', function(evt){
                var team_1 = $(this).data('team-1');
                var team_2 = $(this).data('team-2');
                var match_id = $(this).data('match-id');
                $.getJSON('/director/tournament/resultsmodal', {
                    data: {
                        team_1: team_1,
                        team_2: team_2
                    }
                }, function(data){
                    console.log(data);
                    if(data.status == 'success'){
                        $("#btn-p1, #p1_score_label").html(data.team_1);
                        $("#btn-p2, #p2_score_label").html(data.team_2);
                        $("#btn-p1").data({value: data.team_1_id});
                        $("#btn-p2").data({value: data.team_2_id});
                        $("#match_id").val(match_id);

                        window.STATS.players([]);
                        _.each(data.player_data, function(player){
                            window.STATS.players.push(new Player(player));
                        });

                        $("#challonge_tournaments_modal").modal('show');
                    } else {
                        alert('there was an error');
                    }
                })
            });

            $(".edit_outs_highdart").on('click', function(evt){
                evt.preventDefault();
                var $self = $(this);
                $.getJSON('/director/tournament/outshighdartmodal', {
                    data: {
                        tournament_id: $self.data('tournament-id'),
                        player_id: $self.data('player-id')
                    }
                }, function(data){
                    console.log(data);
                    if(data.status == 'success'){
                    } else {
                        alert('there was an error');
                    }
                });
            });

            // Refresh challonge bracket image
            var d = new Date();
            var bracket_image = "<?php echo $model->challonge_image; ?>";
            setInterval(function(){
                $("#challonge_bracket").attr("src", bracket_image+"?"+d.getTime());
                console.log("refreshing: ", bracket_image);
            }, 1000 * 60 * 5);
        });
    </script>
<?php $this->endClip(); ?>
