<?php

/**
 * This is the model class for table "tournament".
 *
 * The followings are the available columns in table 'tournament':
 * @property integer $id
 * @property integer $challonge_id
 * @property string $challonge_full_url
 * @property string $challonge_url
 * @property string $challonge_image
 * @property string $tournament_type
 * @property string $started
 * @property string $finished
 * @property string $name
 * @property string $date
 * @property integer $participants
 * @property integer $num_of_boards
 * @property string $entry_fee
 * @property string $bar_match
 * @property string $xman
 * @property integer $auto_generate_teams
 * @property integer $high_dart
 * @property integer $high_out
 * @property integer $honey_pot
 * @property integer $mystery_out
 * @property string $high_dart_fee
 * @property string $high_out_fee
 * @property string $honey_pot_fee
 * @property string $mystery_out_fee
 * @property string $creator
 */
class Tournament extends CActiveRecord
{
	public $user_timezone = 'America/Chicago';

	// Between PHP and User                         *** ISO RESULT ***
	public $php_user_short_date = 'm/d/Y';          // dd/mm/yyyy
	public $php_user_time       = 'H:i:s';          // HH:mm:ss
	public $php_user_datetime   = 'm/d/Y H:i:s';    // dd/mm/yyyy HH:mm:ss
	// Between PHP and Db (MySql)
	public $php_db_date         = 'Y-m-d';          // yyyy-mm-dd
	public $php_db_time         = 'H:i:s';          // HH:mm:ss
	public $php_db_datetime     = 'Y-m-d H:i:s';    // yyyy-mm-dd HH:mm:ss

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tournament the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date, tournament_type, entry_fee, bar_match, xman, creator', 'required'),
			array('date', 'unique'),
			array('challonge_id, participants, num_of_boards, auto_generate_teams, high_dart, high_out, honey_pot, mystery_out', 'numerical', 'integerOnly'=>true),
			array('challonge_url, tournament_type', 'length', 'max'=>50),
			array('challonge_full_url, challonge_url, challonge_image', 'length', 'max'=>250),
			array('entry_fee, bar_match, xman, high_dart_fee, high_out_fee, honey_pot_fee, mystery_out_fee', 'length', 'max'=>10),
			array('tournament_type', 'length', 'max'=>50),
			array('name, creator', 'length', 'max'=>120),
			array('name', 'match', 'pattern' => '/^[\w\d\s]+$/', 'message' => 'Can only contain letters, numbers, and underscores.'),
			array('started, finished', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, challonge_id, challonge_full_url, challonge_url, challonge_image, tournament_type, started, finished, name, date, participants, num_of_boards, entry_fee, bar_match, xman, auto_generate_teams, high_dart, high_out, honey_pot, mystery_out, high_dart_fee, high_out_fee, honey_pot_fee, mystery_out_fee, creator', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'players' => array(self::HAS_MANY, 'PlayerTournament', 'tournament_id'),
			'teams' => array(self::HAS_MANY, 'Team', 'tournament_id', 'order' => 'position ASC'),
			'matches' => array(self::HAS_MANY, 'Match', 'tournament_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'challonge_id' => 'Challonge',
			'challonge_full_url' => 'Challonge Full Url',
			'challonge_url' => 'Challonge Url',
			'challonge_image' => 'Challonge Image',
			'tournament_type' => 'Tournament Type',
			'started' => 'Started',
			'finished' => 'Finished',
			'name' => 'Name',
			'date' => 'Date',
			'participants' => 'Participants',
			'num_of_boards' => 'Number Of Boards',
			'entry_fee' => 'Entry Fee',
			'bar_match' => 'Bar Match',
			'xman' => 'Xman Fee',
			'auto_generate_teams' => 'Auto Generate Teams',
			'high_dart' => 'High Dart',
			'high_out' => 'High Out',
			'honey_pot' => 'Honey Pot',
			'mystery_out' => 'Mystery Out',
			'high_dart_fee' => 'High Dart Fee',
			'high_out_fee' => 'High Out Fee',
			'honey_pot_fee' => 'Honey Pot Fee',
			'mystery_out_fee' => 'Mystery Out Fee',
			'creator' => 'Creator',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('challonge_id',$this->challonge_id);
		$criteria->compare('challonge_full_url',$this->challonge_full_url,true);
		$criteria->compare('challonge_url',$this->challonge_url,true);
		$criteria->compare('challonge_image',$this->challonge_image,true);
		$criteria->compare('tournament_type',$this->tournament_type,true);
		$criteria->compare('started',$this->started,true);
		$criteria->compare('finished',$this->finished,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('participants',$this->participants);
		$criteria->compare('num_of_boards',$this->num_of_boards);
		$criteria->compare('entry_fee',$this->entry_fee,true);
		$criteria->compare('bar_match',$this->bar_match,true);
		$criteria->compare('xman',$this->xman,true);
		$criteria->compare('auto_generate_teams',$this->auto_generate_teams);
		$criteria->compare('high_dart',$this->high_dart);
		$criteria->compare('high_out',$this->high_out);
		$criteria->compare('honey_pot',$this->honey_pot);
		$criteria->compare('mystery_out',$this->mystery_out);
		$criteria->compare('high_dart_fee',$this->high_dart_fee,true);
		$criteria->compare('high_out_fee',$this->high_out_fee,true);
		$criteria->compare('honey_pot_fee',$this->honey_pot_fee,true);
		$criteria->compare('mystery_out_fee',$this->mystery_out_fee,true);
		$criteria->compare('creator',$this->creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind()
	{
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{
			/* Test if current column is date/time/timestamp/datetime */
			if (($column->dbType == 'date')     ||
				($column->dbType == 'time')     ||
				($column->dbType == 'timestamp')||
				($column->dbType == 'datetime'))
			{
				/* Test for null column */
				if($this->$columnName === null){
					$test = 0;
				}
				else{
					$test = str_replace(array('/','-', '.', ':', ' '),'',
						$this->$columnName);
				}

				/*  Continue if column is not null, else set column to false -
					which will prevent column being displayed in gridviews if
					gridview data is set like:
					'value' => '($data->mycolumn) ? $data->mycolumn : "" ',
				*/
				if($test > 0)
				{
					/*  Create a new php DateTime object using the
						date/time/timestamp/datetime retrieved from the
						database.
						Set the object's timezone to UTC (same as the
						server's timezone) */
					$datetime_object = new
						DateTime($this->$columnName,
							new DateTimeZone('UTC') );

					/*  Change the DateTime object's timezone
					and format, based on the column's data
					type in the DB.
					Note: changing the object's timezone will
					automatically also change its time. */
					switch ($column->dbType)
					{
						case 'date':
							/* Convert the object's time to the user's time */
								// Do not take any action here. Date columns do
								// not include the time and thus cannot be
								// converted.
							/* Output the required format */
							$this->$columnName =
								$datetime_object->format(
									$this->php_user_short_date);
							break;

						case 'time':
							/*  Convert the object's time to the user's time */
							$datetime_object->setTimeZone(new
								DateTimeZone($this->user_timezone));
							/* Output the required format */
							$this->$columnName =
								$datetime_object->format($this->php_user_time);
							break;

						case 'timestamp':
							/*  Convert the object's time to the user's time */
							$datetime_object->setTimeZone(new
								DateTimeZone($this->user_timezone));
							/* Output the required format */
							$this->$columnName =
								$datetime_object->format(
									$this->php_user_datetime);
							break;

						case 'datetime':
							/*  Convert the object's time to the user's time */
							$datetime_object->setTimeZone(new
								DateTimeZone($this->user_timezone));
							/* Output the required format */
							$this->$columnName =
								$datetime_object->format(
									$this->php_user_datetime);
							break;
					}
				}
				else{
					$this->$columnName = false;
				}
			}
		}
		return parent::afterFind();
	}

	protected function beforeSave()
	{

		/*  Reformat date/time/timestamp/datetime from local format and timezone
			to database format and UTC. */
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{
			/* Test if current column is date/time/timestamp/datetime */
			if (($column->dbType == 'date')     ||
				($column->dbType == 'time')     ||
				($column->dbType == 'timestamp')||
				($column->dbType == 'datetime'))
			{
				/* Test for null column */
				if($this->$columnName === null){
					$test = 0;
				}
				else{
					$test = str_replace(array('/','-', '.', ':', ' '),'',
						$this->$columnName);
				}

				/* Continue if column is not null. */
				if($test > 0)
				{
					switch ($column->dbType)
					{
						case 'date':
							/* create datetime object */
							$datetime_object = new DateTime($this->$columnName);
							// $datetime_object = DateTime::createFromFormat(
							//     $this->php_user_short_date,
							//     $this->$columnName,
							//     new DateTimeZone($this->user_timezone));
							/* change timezone to UTC */
								// Do not take any action. Do not convert the
								// timezone for dates, because the time is not
								// included in the data saved to the db, which
								// means that the data cannot be converted back.
							/* change format to DB format */
							$this->$columnName =
								$datetime_object->format($this->php_db_date);
							break;

						case 'time':
							/* create datetime object */
							$datetime_object = new DateTime($this->$columnName);
							// $datetime_object = DateTime::createFromFormat(
							//     $this->php_user_time,
							//     $this->$columnName,
							//     new DateTimeZone($this->user_timezone));
							/* change timezone to UTC */
							$datetime_object->setTimeZone(new
								DateTimeZone('UTC'));
							/* change format to DB format */
							$this->$columnName =
								$datetime_object->format($this->php_db_time);
							break;

						case 'timestamp':
							/* create datetime object from user's format */
							$datetime_object = new DateTime($this->$columnName);
							// $datetime_object = DateTime::createFromFormat(
							//     $this->php_user_datetime,
							//     $this->$columnName,
							//     new DateTimeZone($this->user_timezone));
							/* change timezone to UTC */
							$datetime_object->setTimeZone(new
								DateTimeZone('UTC'));
							/* change format to DB format */
							$this->$columnName =
								$datetime_object->format($this->php_db_datetime);
							break;

						case 'datetime':
							/* create datetime object */
							$datetime_object = new DateTime($this->$columnName);
							// $datetime_object = DateTime::createFromFormat(
							//     $this->php_user_datetime,
							//     $this->$columnName,
							//     new DateTimeZone($this->user_timezone));
							/* change timezone to UTC */
							$datetime_object->setTimeZone(new
															DateTimeZone($this->user_timezone));
							/* change format to DB format */
							$this->$columnName =
								$datetime_object->format($this->php_db_datetime);
							break;
					}
				}
			}
		}
		return parent::beforeSave();
	}

	public function tournamentInPast()
	{
		$now = new DateTime();
		$today = $now->format('m/d/Y');

		return $today > $this->date;
	}

	public function toJSON()
	{
		$tournament = array();
		$tournament['id'] = $this->id;
		$tournament['date'] = $this->date;
		$tournament['entry_fee'] = $this->entry_fee;
		$tournament['bar_match'] = $this->bar_match;
		$tournament['xman'] = $this->xman;
		$tournament['auto_generate_teams'] = (bool)$this->auto_generate_teams;
		$tournament['high_dart'] = (bool)$this->high_dart;
		$tournament['high_out'] = (bool)$this->high_out;
		$tournament['mystery_out'] = (bool)$this->mystery_out;
		$tournament['honey_pot'] = (bool)$this->honey_pot;
		$tournament['high_dart_fee'] = $this->high_dart_fee;
		$tournament['high_out_fee'] = $this->high_out_fee;
		$tournament['mystery_out_fee'] = $this->mystery_out_fee;
		$tournament['honey_pot_fee'] = $this->honey_pot_fee;
		$tournament['teams_selected'] = $this->teams_selected();
		$tournament['teams'] = $this->get_teams();

		return CJSON::encode($tournament);
	}

	public function registered_players()
	{
		$registered_players = PlayerTournament::model()->findAllByAttributes(array(
			'tournament_id' => $this->id
		),
		array(
			'order' => 'player_id'
		));

		$_registered_players = array();
		foreach($registered_players as $rp)
		{
			$tmp = array();
			$tmp['id'] = $rp->id;
			$tmp['player_id'] = $rp->player->id;
			$tmp['name'] = $rp->player->getFullName(true);
			$tmp['high_dart'] = (bool)$rp->high_dart;
			$tmp['high_out'] = (bool)$rp->high_out;
			$tmp['mystery_out'] = (bool)$rp->mystery_out;
			$tmp['honey_pot'] = (bool)$rp->honey_pot;
			$tmp['female'] = (bool)$rp->player->female;
			$tmp['xman'] = (bool)$rp->xman;
			$tmp['chip_pulled'] = $rp->chip_pulled;
			$_registered_players[$rp->id] = $tmp;
		}

		return CJSON::encode($_registered_players);
	}

	public function get_teams()
	{
		$_teams = array();
		foreach($this->teams as $team)
		{
			$_teams[$team['position']][] = $team->player->getFullName(true);
		}
		ksort($_teams);

		return $_teams;
	}

	public function teams_selected()
	{
		$teams = Team::model()->findAllByAttributes(array(
			'tournament_id' => $this->id
		));

		$players = PlayerTournament::model()->findAllByAttributes(array(
			'tournament_id' => $this->id
		));

		return count($teams) == count($players) && count($teams) > 0;
	}

	public function tournamentTypeDropDown()
	{
		$return = array(
			'single elimination' => 'Single Elimination',
			'double elimination' => 'Double Elimination'
		);

		return $return;
	}

	public function get_team_name($position)
	{
		$team = Team::model()->findAllByAttributes(array(
			'tournament_id' => $this->id,
			'position' => $position
		));

		$team_name = '';
		foreach($team as $t){
			$player_name = explode(' ', $t->player->name);
			$team_name .= $player_name[0] . " " . $player_name[1][0] . "." . " & ";
		}

		return rtrim($team_name, ' & ');
	}

	public function get_match_display()
	{
		$matches = Match::model()->findAllByAttributes(array(
			'tournament_id' => $this->id
		), array(
			'order' => 'identifier'
		));

		$return = array();
		$return['winners'] = array();
		$return['winners']['open'] = array();
		$return['winners']['complete'] = array();
		$return['losers'] = array();
		$return['losers']['open'] = array();
		$return['losers']['complete'] = array();
		foreach($matches as $match){
			if($match->round > 0){
				// Winners
				if($match->state == 'complete'){
					$return['winners']['complete'][] = $match;
				} elseif($match->state == 'open'){
					$return['winners']['open'][] = $match;
				}
			} else {
				// Losers
				if($match->state == 'complete'){
					$return['losers']['complete'][] = $match;
				} elseif($match->state == 'open'){
					$return['losers']['open'][] = $match;
				}
			}
		}

		return $return;
	}

	public function updateMatchesFromChallonge(){
		$c = new ChallongeAPI(Yii::app()->params['challonge_api']);
		$params = array();
		$matches = $c->getMatches($this->challonge_id, $params);

		foreach($matches as $k => $match){
			$_match = Match::model()->findByAttributes(array(
				'tournament_id' => $this->id,
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
	}

	public function getOrderedPlayerList(){
		$_players = array();
		foreach($this->players as $player){
			$_players[] = $player->player;
		}

		function cmp($a, $b){
			return strcmp($a->name, $b->name);
		}

		usort($_players, "cmp");

		return $_players;
	}
}
