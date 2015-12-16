<?php

/**
 * This is the model class for table "match".
 *
 * The followings are the available columns in table 'match':
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $challonge_tournament_id
 * @property integer $challonge_match_id
 * @property integer $team_1
 * @property integer $team_2
 * @property string $identifier
 * @property integer $round
 * @property string $state
 * @property integer $winner
 * @property integer $loser
 * @property integer $board
 */
class Match extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Match the static model class
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
		return 'match';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tournament_id, challonge_tournament_id, challonge_match_id, team_1, team_2, round, winner, loser, board', 'numerical', 'integerOnly'=>true),
			array('identifier, state', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tournament_id, challonge_tournament_id, challonge_match_id, team_1, team_2, identifier, round, winner, loser, board', 'safe', 'on'=>'search'),
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
			'tournament' => array(self::BELONGS_TO, 'Tournament', 'tournament_id'),
			'team_1' => array(self::HAS_MANY, 'Team', '', 'on' => 'challonge_participant_id=team_1', 'joinType' => 'INNER JOIN'),
			'team_2' => array(self::HAS_MANY, 'Team', '', 'on' => 'team_2=challonge_participant_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tournament_id' => 'Tournament',
			'challonge_tournament_id' => 'Challonge Tournament',
			'challonge_match_id' => 'Challonge Match',
			'team_1' => 'Team 1',
			'team_2' => 'Team 2',
			'identifier' => 'Identifier',
			'round' => 'Round',
			'state' => 'State',
			'winner' => 'Winner',
			'loser' => 'Loser',
			'board' => 'Board',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// scandir(directory)hould not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tournament_id',$this->tournament_id);
		$criteria->compare('challonge_tournament_id',$this->challonge_tournament_id);
		$criteria->compare('challonge_match_id',$this->challonge_match_id);
		$criteria->compare('team_1',$this->team_1);
		$criteria->compare('team_2',$this->team_2);
		$criteria->compare('identifier',$this->identifier,true);
		$criteria->compare('round',$this->round);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('winner',$this->winner);
		$criteria->compare('loser',$this->loser);
		$criteria->compare('board',$this->board);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function get_match_display($full_name=true)
	{
		$team = Team::model()->findAllByAttributes(array(
			'tournament_id' => $this->tournament->id,
			'challonge_participant_id' => $this->team_1
		));

		$team_name = '';
		foreach($team as $t){
			if($full_name){
				$team_name .= $t->player->name . " / ";
			} else {
				$player_name = explode(' ', $t->player->name);
				$team_name .= $player_name[0] . " " . $player_name[1][0] . "." . " / ";
			}
		}

		$team_name = rtrim($team_name, ' / ');

		$team_name .= ' vs ';

		$team = Team::model()->findAllByAttributes(array(
			'tournament_id' => $this->tournament->id,
			'challonge_participant_id' => $this->team_2
		));

		foreach($team as $t){
			if($full_name){
				$team_name .= $t->player->name . " / ";
			} else {
				$player_name = explode(' ', $t->player->name);
				$team_name .= $player_name[0] . " " . $player_name[1][0] . "." . " / ";
			}
		}

		return rtrim($team_name, ' / ');
	}
}
