<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "assign_tasks".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $task_name
 * @property string $due_date
 * @property string $priority
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $employee
 */
class AssignTasks extends \yii\db\ActiveRecord
{

    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assign_tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_name', 'due_date', 'priority'], 'required'],
            [['employee_id'], 'integer'],
            [['due_date', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['task_name', 'priority'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'task_name' => 'Task Name',
            'due_date' => 'Due Date',
            'priority' => 'Priority',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::class, ['id' => 'employee_id']);
    }

    public function getPriorityLabel()
    {
        $labels = [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
        ];

        return $labels[$this->priority] ?? null;
    }
}
