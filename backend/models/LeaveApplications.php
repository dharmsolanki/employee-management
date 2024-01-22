<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "leave_applications".
 *
 * @property int $id
 * @property int $user_id
 * @property string $leave_type
 * @property string $start_date
 * @property string $end_date
 * @property string $reason
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $reject_reason
 * @property User $user
 */
class LeaveApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_applications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'leave_type', 'start_date', 'end_date'], 'required'],
            [['user_id'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['reason', 'reject_reason'], 'string'],
            [['leave_type', 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'leave_type' => 'Leave Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'reason' => 'Reason',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
