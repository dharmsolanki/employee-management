<?php

namespace backend\controllers;

use app\models\LeaveApplications;
use backend\modules\api\models\AssignTasks;
use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['approve-leave'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'approve-leave', 'reject-leave', 'pending-leaves', 'approved-leaves', 'rejected-leaves', 'assign-task', 'assign-tasks-list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $pendingLeaves = LeaveApplications::find()->where(['status' => 0])->all();
        $approvedLeaves = LeaveApplications::find()->where(['status' => 1])->all();
        $rejectedLeaves = LeaveApplications::find()->where(['status' => 2])->all();
        $user = User::find()->all();
        $tasks = AssignTasks::find()->all();

        return $this->render('index', [
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'rejectedLeaves' => $rejectedLeaves,
            'user' => $user,
            'tasks' => $tasks
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post()['LoginForm']['username'] === 'admin' && $model->login()) {

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionApproveLeave($userId, $id)
    {
        $model = LeaveApplications::find()->where(['user_id' => $userId, 'id' => $id])->one();
        $model->user_id = $userId;
        $model->status = 1;
        $model->save(false);

        return $this->redirect(['site/pending-leaves']);
    }

    public function actionRejectLeave($userId, $id)
    {
        $model = LeaveApplications::find()->where(['user_id' => $userId, 'id' => $id])->one();

        if (Yii::$app->request->isGet) {
            // Handle the reject reason submission
            $rejectReason = Yii::$app->request->get('reason');
            // Save the reject reason to the database (you may want to add validation and error handling)
            $model->reject_reason = $rejectReason;
        }

        $model->user_id = $userId;
        $model->status = 2;
        $model->save(false);

        return $this->redirect(['site/index']);
    }

    public function actionPendingLeaves()
    {
        $pendingLeaves = LeaveApplications::find()->where(['status' => 0])->all();

        return $this->render('pendingLeaves', [
            'pendingLeaves' => $pendingLeaves,
        ]);
    }

    public function actionApprovedLeaves()
    {
        $approvedLeaves = LeaveApplications::find()->where(['status' => 1])->all();

        return $this->render('approvedLeaves', [
            'approvedLeaves' => $approvedLeaves,
        ]);
    }

    public function actionRejectedLeaves()
    {
        $rejectedLeaves = LeaveApplications::find()->where(['status' => 2])->all();

        return $this->render('rejectedLeaves', [
            'rejectedLeaves' => $rejectedLeaves,
        ]);
    }

    public function actionAssignTask()
    {
        $model = new AssignTasks();
        if (Yii::$app->request->isPost) {
            $model->employee_id = Yii::$app->request->post('employee_id');
            $model->task_name = Yii::$app->request->post('task_name');
            $model->due_date = Yii::$app->request->post('due_date');
            $model->priority = Yii::$app->request->post('priority');
            $model->description = Yii::$app->request->post('description');
            $model->save(false);
        }
        return $this->redirect(['site/index']);
    }

    public function actionAssignTasksList()
    {
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => AssignTasks::find()->all(),
            'pagination' => [
                'pageSize' => 10, // Set the number of items per page
            ],
        ]);

        return $this->render('assignTasksList', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
