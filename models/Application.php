<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int      $id
 * @property string   $title
 * @property string   $short_title
 * @property string   $googleplay_id
 * @property int      $appstore_id
 * @property int      $developer_id
 *
 * @property int      $created_at
 * @property int      $updated_at
 *
 * @property Developer $developer
 */
class Application extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'application';
    }


    /** {@inheritdoc} */
    public function behaviors() : array
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['title', 'short_title', 'googleplay_id', 'appstore_id', 'developer_id'], 'required'],
            [['appstore_id', 'developer_id'], 'integer'],
            [['title', 'short_title', 'googleplay_id'], 'string', 'max' => 255],
            [['developer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Developer::class, 'targetAttribute' => ['developer_id' => 'id']],
        ];
    }


    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'short_title'   => 'Short Title',
            'googleplay_id' => 'Googleplay ID',
            'appstore_id'   => 'Appstore ID',
            'developer_id'  => 'Developer ID',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDeveloper()
    {
        return $this->hasOne(Developer::class, ['id' => 'developer_id']);
    }
}
