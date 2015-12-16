<?php
Yii::import('ext.ChallongeAPI');

class TournamentController extends DirectorController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'create','update', 'players', 'teams', 'addplayertotournament',
					'removeplayerfromtournament', 'addxman', 'redrawteams', 'starttournament',
					'matches', 'updatematches', 'resultsmodal', 'matchresults', 'finalizetournament',
					'addplayertodbandtournament', 'outshighdartmodal'
				),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the gmodel to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
			'registered_players' => $model->registered_players()
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tournament;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tournament']))
		{
			$model->attributes=$_POST['Tournament'];

			if($model->validate()){

				// Set up the challonge tournament before we save ours.  if this fails we need to stop
				$challonge_url = str_replace(' ', '_', strtolower($model->name)) . "_" . str_replace('/', '_', $model->date);
				$challone_name = $model->name . " " . $model->date;

				$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
				$params = array(
					"tournament[name]" => $challone_name,
					"tournament[tournament_type]" => $model->tournament_type,
					"tournament[url]" => $challonge_url,
					"tournament[sequential_pairings]" => 'true'
				);
				$tournament = $c->createTournament($params)->tournament;

				if(count($c->errors)){
					foreach($c->errors as $error){
						Yii::app()->user->setFlash('error', "Challonge ERROR: " .$error);
					}
				} else {
					if(!$tournament){
						Yii::app()->user->setFlash('error', "Was not able to create a tournament in the challonge software");
					} else {
						$model->challonge_id = $tournament->id;
						$model->challonge_full_url = $tournament->full_challonge_url;
						$model->challonge_url = $tournament->url;
						$model->challonge_image = $tournament->live_image_url;

						if($model->save())
						{
							Yii::app()->user->setFlash('success', 'Tournament created');
							$this->redirect(array('players', 'id' => $model->id));
						}
					}
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if($model->tournamentInPast() || $model->started){
			Yii::app()->user->setFlash('warning', 'You can no longer update this tournament');
			$this->redirect(array('index'));
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tournament']))
		{
			$model->attributes=$_POST['Tournament'];

			// Set up the challonge tournament before we save ours.  if this fails we need to stop
			$challonge_url = str_replace(' ', '_', strtolower($model->name)) . "_" . str_replace('/', '_', $model->date);
			$challone_name = $model->name . " " . $model->date;

			$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
			$params = array(
				"tournament[name]" => $challone_name,
				"tournament[tournament_type]" => $model->tournament_type,
				"tournament[url]" => $challonge_url,
				"tournament[sequential_pairings]" => 'true'
			);
			$tournament = $c->updateTournament($model->challonge_id, $params);

			if(count($c->errors)){
				foreach($c->errors as $error){
					Yii::app()->user->setFlash('error', "Challonge ERROR: " .$error);
				}
			} else {
				if($tournament){
					$model->challonge_url = $tournament->{'full-challonge-url'};
				}

				if($model->save())
				{
					Yii::app()->user->setFlash('success', 'Tournament updated');
					$this->redirect(array('players', 'id' => $model->id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tournament', array(
			'criteria' => array(
				'order' => 'date DESC'
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPlayers($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Tournament']['info']))
		{
			$error = false;
			$data = CJSON::decode($_POST['Tournament']['info']);

			$model->participants = $data['numberOfParticipants'];
			$model->save();

			foreach($data['players'] as $key => $player)
			{
				$_player = PlayerTournament::model()->findByPk($player['id']);

				if(!$_player){
					// Create new player for tournament
					$_player = new PlayerTournament;
				}

				$_player->tournament_id = $id;
				$_player->player_id = $player['player_id'];
				$_player->high_dart = ($player['high_dart']) ? $player['high_dart'] : 0;
				$_player->high_out = ($player['high_out']) ? $player['high_out'] : 0;
				$_player->mystery_out = ($player['mystery_out']) ? $player['mystery_out'] : 0;
				$_player->honey_pot = ($player['honey_pot']) ? $player['honey_pot'] : 0;
				$_player->xman = ($player['xman']) ? $player['xman'] : 0;
				$_player->entry_fee = $player['entry_fee'];

				if(!$_player->save())
				{
					$error = true;
				}

				// If we are odd and have an xman remove the xman to make it even.
				if(!($data['numberOfParticipants'] % 2 === 0) && $_player->xman)
				{
					$_player->delete();
					Yii::app()->user->setFlash('warning', 'The xman was removed because there is an even number of players');
				}
			}

			if(!$error)
			{
				Yii::app()->user->setFlash('success', 'Players saved.');
				$this->redirect(array('teams', 'id' => $id));
			}

			$message = "";
			foreach($_player->getErrors() as $error)
			{
				$message .= $error ."<br />";
			}
			Yii::app()->user->setFlash('error', $message);
		}

		$players = Player::model()->findAll();

		$_players = array();
		$_playersJSON = array();
		foreach($players as $player)
		{
			$name = $player->getFullName(true);
			$_players[] = $name;
			$tmp = array();
			$tmp['id'] = $player->id;
			$tmp['name'] = $name;
			$tmp['nickname'] = $player->nickname;
			$tmp['female'] = (bool)$player->female;
			$_playersJSON[$name] = $tmp;
		}

		$this->render('players', array(
			'model' => $model,
			'players' => $_players,
			'playersJSON' => CJSON::encode($_playersJSON),
			'registered_players' => $model->registered_players()
		));
	}

	public function actionMatches($id)
	{
		$model = $this->loadModel($id);

		// $model->updateMatchesFromChallonge();

		$matches = $model->get_match_display();

		// $completed_matches = Match::model()->findAllByAttributes(array(
		// 	'tournament_id' => $model->id,
		// 	'state' => 'complete'
		// ), array(
		// 	'order' => 'identifier'
		// ));

		$this->render('matches', array(
			'model' => $model,
			'matches' => $matches,
			// 'completed_matches' => $completed_matches
		));
	}

	public function actionUpdateMatches($id)
	{
		$model = $this->loadModel($id);
		$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
		$params = array();
		$matches = $c->getMatches($model->challonge_id, $params);

		foreach($matches as $k => $match){
			$_match = Match::model()->findByAttributes(array(
				'tournament_id' => $id,
				'challonge_match_id' => $match->match->id
			));

			if($_match){
				$_match->team_1 = strlen($match->match->player1_id) ? $match->match->player1_id : '';
				$_match->team_2 = strlen($match->match->player2_id) ? $match->match->player2_id : '';
				$_match->identifier = $match->match->identifier;
				$_match->round = $match->match->round;
				$_match->state = $match->match->state;
				$_match->winner = $match->match->winner_id;
				$_match->loser = $match->match->loser_id;
				$_match->save();
			}
		}

		echo "<pre>";
			print_r($matches);
		echo "</pre>";
	}

	public function actionStartTournament($id)
	{
		$model = $this->loadModel($id);
		$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
		$params = array(
			'include_matches' => 1,
			'include_participants' => 1
		);
		$tournament_id = $model->challonge_id;
		$tournament = $c->startTournament($tournament_id, $params)->tournament;
		$model->started = date('Y-m-d H:i:s');
		$model->save();

		// echo "<pre>";print_r($tournament);echo "</pre>";//exit;

		if(count($c->errors)){
			foreach($c->errors as $error){
				Yii::app()->user->setFlash('error', 'Challonge Error: ' . $error);
			}

			$this->redirect(array('teams', 'id' => $id));
		}

		foreach($tournament->matches as $k => $match){
			// print $k."<br />";
			// print_r($match);
			// print "<br />-------------------<br />";
			try{
				$_match = new Match;
				$_match->tournament_id = $id;
				$_match->challonge_tournament_id = $model->challonge_id;
				$_match->challonge_match_id = $match->match->id;
				$_match->team_1 = strlen($match->match->player1_id) ? $match->match->player1_id : '';
				$_match->team_2 = strlen($match->match->player2_id) ? $match->match->player2_id : '';
				$_match->identifier = $match->match->identifier;
				$_match->round = $match->match->round;
				$_match->state = $match->match->state;
				$_match->save();
			} catch(CDbException $e){
				continue;
			}
		}

		$model->updateMatchesFromChallonge();

		// exit;

		$this->redirect(array('matches', 'id' => $id));
	}

	public function actionTeams($id)
	{
		$model = $this->loadModel($id);

		$players = $model->players;

		if(isset($_POST['Teams']['info']))
		{
			$error = false;
			$data = CJSON::decode($_POST['Teams']['info']);

			foreach($data['players'] as $key => $player)
			{
				$_player = PlayerTournament::model()->findByPk($player['id']);

				$_player->chip_pulled = $player['chip_pulled'];

				if(!$_player->save())
				{
					$error = true;
				}

				$team = new Team;
				$team->tournament_id = $id;
				$team->player_id = $player['player_id'];
				$team->position = $player['chip_pulled'];

				if(!$team->save())
				{
					$error = true;
				}
			}

			$teams = $model->get_teams();
			//echo "<pre>";print_r($teams);echo "</pre>";exit;
			$max_teams = Team::model()->findAllByAttributes(array(
				'tournament_id' => $model->id
			), array(
				'order' => 'position DESC'
			));

			$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
			foreach(range(1, $max_teams[0]->position) as $position){
				$params = array(
					"participant[name]" => $model->get_team_name($position),
					"participant[seed]" => $position
				);
				$participant = $c->createParticipant($model->challonge_id, $params)->participant;
				if($participant){
					Team::model()->updateAll(array(
						'challonge_participant_id' => $participant->id
					), "tournament_id = {$model->id} and position = {$position}");
				}
			}

			if(!$error)
			{
				Yii::app()->user->setFlash('success', 'Teams saved.');
				$this->redirect(array('teams', 'id' => $id));
			}

			$message = "";
			foreach($_player->getErrors() as $error)
			{
				$message .= $error ."<br />";
			}
			Yii::app()->user->setFlash('error', $message);
		}

		$this->render('teams', array(
			'model' => $model,
			'players' => $players,
			'registered_players' => $model->registered_players(),
			'teams' => $model->get_teams()
		));
	}

	protected function addToTournament($tournament_id, $player)
	{
		$message = 'success';

		$_player = PlayerTournament::model()->findByAttributes(array(
			'player_id' => $player_id['id'],
			'tournament_id' => $tournament_id
		));

		if(!$_player){
			// Create new player for tournament
			$_player = new PlayerTournament;
		}

		$_player->tournament_id = $tournament_id;
		$_player->player_id = $player['id'];
		$_player->high_dart = ($player['high_dart'] == 'true') ? 1 : 0;
		$_player->high_out = ($player['high_out'] == 'true') ? 1 : 0;
		$_player->mystery_out = ($player['mystery_out'] == 'true') ? 1 : 0;
		$_player->honey_pot = ($player['honey_pot'] == 'true') ? 1 : 0;
		$_player->female = ($player['female'] == 'true') ? 1 : 0;
		$_player->entry_fee = 0.00;

		if(!$_player->save()){
			$message = '';
			foreach($_player->getErrors() as $key => $field)
			{
				foreach($field as $key => $error)
				{
					$message .= $error;
				}
			}
		}

		return array($message, $_player);
	}

	public function actionAddPlayerToDbAndTournament()
	{
		// This is garbage
		// Refactor
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		if(isset($_GET['data']))
		{
			$data = $_GET['data'];
			$tournament_id = $data['tournament_id'];
			$player = $data['player'];

			$_player = new Player;
			$_player->name = $player['name'];
			$_player->nickname = $player['nickname'];
			$_player->female = ($player['female'] == 'true') ? 1 : 0;

			if($_player->save()){
				$player['id'] = Yii::app()->db->getLastInsertId();
				$_player->name = $_player->getFullName(true);
				list($message, $Tplayer) = $this->addToTournament($tournament_id, $player);
			} else {
				$message = 'There was a problem saving the player';
				$_player->id = null;
			}


			echo CJSON::encode(array('status' => $message, 'id' => $Tplayer->id, 'player' => $_player));
		}
	}

	public function actionAddPlayerToTournament()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		if(isset($_GET['data']))
		{
			$data = $_GET['data'];
			$tournament_id = $data['tournament_id'];
			$player = $data['player'];

			list($message, $_player) = $this->addToTournament($tournament_id, $player);

			echo CJSON::encode(array('status' => $message, 'id' => $_player->id));
		}
	}

	public function actionRemovePlayerFromTournament()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		$message = 'fail';

		if(isset($_GET['data']))
		{
			$data = $_GET['data'];
			$pt = PlayerTournament::model()->findByPk($data['id']);

			if(!is_null($pt) && $pt->delete()){
				$message = 'success';
			}
		}

		echo CJSON::encode(array('status' => $message));
	}

	public function actionAddXman()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		$message = 'fail';

		if(isset($_GET['data']))
		{
			$data = $_GET['data'];
			$current_xman = PlayerTournament::model()->findByAttributes(array(
				'tournament_id' => $data['tournament_id'],
				'xman' => 1
			));

			$tournament = Tournament::model()->findByPk($data['tournament_id']);
			$player = Player::model()->findByPk($data['player_id']);


			if(!is_null($current_xman))
			{
				$current_xman->delete();
			}

			$pt = new PlayerTournament;
			$pt->tournament_id = $data['tournament_id'];
			$pt->player_id = $data['player_id'];
			$pt->entry_fee = $tournament->xman;
			$pt->xman = 1;
			$pt->female = $player->female;
			if($pt->save()){
				$message = 'success';
				// Needs to be blank for UI to not display everyone as a femmale
				$player->female = $player->female ? $player->female : '';
				$player->name = $player->getFullName(true);
			}
		}

		echo CJSON::encode(array('status' => $message, 'xman' => $pt, 'player' => $player));
	}

	public function actionRedrawTeams()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		$message = 'fail';

		if(isset($_GET['data']))
		{
			$tournament_id = $_GET['data']['tournament_id'];
			$tournament = Tournament::model()->findByPk($tournament_id);
			$teams = $tournament->teams;
			$ids = array();
			foreach($teams as $player){
				$ids[] = $player->challonge_participant_id;
			}

			if(count($ids)){
				$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
				foreach(array_unique($ids) as $challonge_id){
					if($challonge_id){
						$c->deleteParticipant($tournament->challonge_id, $challonge_id);
					}
				}
			}

			$deleted = Team::model()->deleteAllByAttributes(array('tournament_id' => $tournament_id));
			$updated = PlayerTournament::model()->updateAll(array(
				'chip_pulled' => null
			), 'tournament_id = '.$tournament_id);

			if($deleted > 0 && $updated > 0){
				$message = 'success';
			}
		}

		echo CJSON::encode(array('status' => $message));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tournament('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tournament']))
			$model->attributes=$_GET['Tournament'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionOutsHighDartModal()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		$message = 'success';

		if(isset($_GET['data']))
		{
			$data = $_GET['data'];
			$tournament_id = $data['tournament_id'];
			$player_id = $data['player_id'];

			$player = Player::model()->findByPk($player_id);
			$outs = $player->getOuts($tournament_id);
			$high_dart = $player->getHighDart($tournament_id);
		}

		echo CJSON::encode(array(
			'status' => $message,
			'outs' => $outs,
			'high_dart' => $high_dart
		));
	}

	public function actionResultsModal()
	{
		if(Yii::app()->request->isPostRequest)
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		$message = 'fail';

		if(isset($_GET['data']))
		{
			$team_1 = $_GET['data']['team_1'];
			$team_2 = $_GET['data']['team_2'];

			$player_data = array();

			$team = Team::model()->findAllByAttributes(array(
				'challonge_participant_id' => $team_1
			));

			$team1 = '';
			foreach($team as $t){
				$player_name = explode(' ', $t->player->name);
				$team1 .= $player_name[0] . " " . $player_name[1][0] . "." . " / ";
				$player_data[] = array('name' => $t->player->name, 'id' => $t->player_id);
			}

			$team1 = rtrim($team1, ' / ');

			$team = Team::model()->findAllByAttributes(array(
				'challonge_participant_id' => $team_2
			));

			$team2 = '';
			foreach($team as $t){
				$player_name = explode(' ', $t->player->name);
				$team2 .= $player_name[0] . " " . $player_name[1][0] . "." . " / ";
				$player_data[] = array('name' => $t->player->name, 'id' => $t->player_id);
			}

			$team2 = rtrim($team2, ' / ');

			$message = 'success';
		}

		echo CJSON::encode(array(
			'status' => $message,
			'team_1' => $team1,
			'team_2' => $team2,
			'team_1_id' => $team_1,
			'team_2_id' => $team_2,
			'player_data' => $player_data
		));
	}

	public function actionmatchresults($id)
	{
		$model = $this->loadModel($id);
		$tournament_id = $model->challonge_id;
		if(isset($_POST['winner_id']) && isset($_POST['match_id'])){
			$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
			$match_id = $_POST['match_id'];
			$csv = ($_POST['team_number'] == 1) ? "1-0" : "0-1";
			$params = array(
				"match[scores_csv]" => $csv,
				"match[winner_id]" => $_POST['winner_id']
			);
			$match = $c->updateMatch($tournament_id, $match_id, $params);
			if(count($c->errors)){
				foreach($c->errors as $error){
					Yii::app()->user->setFlash('error', "Challonge ERROR: " .$error);
				}
			} else {
				$model->updateMatchesFromChallonge();
			}

			$outs = $_POST['Data']['outs'];
			$high_darts = $_POST['Data']['high_dart'];

			// echo "<pre>";
			// 	print_r($_POST);
			// 	print_r($outs);
			// echo "</pre>";


			foreach($outs as $game)
			{
				foreach($game as $player_id => $out)
				{
					if($out > 0)
					{
						$highout = new HighOut;
						$highout->tournament_id = $id;
						$highout->player_id = $player_id;
						$highout->high_out = $out;
						$highout->save();
					}
				}
			}

			foreach($high_darts as $player_id => $high_dart)
			{
				if($high_dart > 0)
				{
					$highdart = new HighDart;
					$highdart->tournament_id = $id;
					$highdart->player_id = $player_id;
					$highdart->high_dart = $high_dart;
					$highdart->save();
				}
			}
		}

		$this->redirect(array('matches', 'id' => $model->id));
	}

	public function actionFinalizeTournament($id)
	{
		$model = $this->loadModel($id);
		$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
		$params = array(
			'include_matches' => 1,
			'include_participants' => 1
		);
		$tournament_id = $model->challonge_id;
		$tournament = $c->publishTournament($tournament_id, $params)->tournament;
		$model->finished = date('Y-m-d H:i:s');
		$model->save();

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tournament::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tournament-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
