<?php

/**
 * This is the model class for table "high_out".
 *
 * The followings are the available columns in table 'high_out':
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $player_id
 * @property integer $high_out
 */
class HighOut extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HighOut the static model class
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
		return 'high_out';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tournament_id, player_id, high_out', 'required'),
			array('tournament_id, player_id, high_out', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tournament_id, player_id, high_out', 'safe', 'on'=>'search'),
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
			'high_out' => 'High Out',
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
		$criteria->compare('high_out',$this->high_out);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}