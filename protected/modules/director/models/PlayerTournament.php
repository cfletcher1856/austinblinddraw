<?php

/**
 * This is the model class for table "player_tournament".
 *
 * The followings are the available columns in table 'player_tournament':
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $player_id
 * @property integer $high_dart
 * @property integer $high_out
 * @property integer $mystery_out
 * @property integer $honey_pot
 * @property double $entry_fee
 * @property integer $chip_pulled
 * @property integer $xman
 * @property integer $place
 * @property double $winnings
 */
class PlayerTournament extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlayerTournament the static model class
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
		return 'player_tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tournament_id, player_id, high_dart, high_out, mystery_out, honey_pot, entry_fee', 'required'),
			array('tournament_id, player_id, high_dart, high_out, mystery_out, honey_pot, chip_pulled, xman, place', 'numerical', 'integerOnly'=>true),
			array('entry_fee, winnings', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tournament_id, player_id, high_dart, high_out, mystery_out, honey_pot, entry_fee, chip_pulled, xman, place, winnings', 'safe', 'on'=>'search'),
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
			'player' => array(self::BELONGS_TO, 'Player', 'player_id'),
			'players' => array(self::HAS_MANY, 'Player', 'player_id')
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
			'player_id' => 'Player',
			'high_dart' => 'High Dart',
			'high_out' => 'High Out',
			'mystery_out' => 'Mystery Out',
			'honey_pot' => 'Honey Pot',
			'entry_fee' => 'Entry Fee',
			'chip_pulled' => 'Chip Pulled',
			'xman' => 'Xman',
			'place' => 'Place',
			'winnings' => 'Winnings',
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
		$criteria->compare('tournament_id',$this->tournament_id);
		$criteria->compare('player_id',$this->player_id);
		$criteria->compare('high_dart',$this->high_dart);
		$criteria->compare('high_out',$this->high_out);
		$criteria->compare('mystery_out',$this->mystery_out);
		$criteria->compare('honey_pot',$this->honey_pot);
		$criteria->compare('entry_fee',$this->entry_fee);
		$criteria->compare('chip_pulled',$this->chip_pulled);
		$criteria->compare('xman',$this->xman);
		$criteria->compare('place',$this->place);
		$criteria->compare('winnings',$this->winnings);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
