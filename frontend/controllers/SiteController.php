<?php

namespace frontend\controllers;

use app\models\LeaveApplications;
use backend\modules\api\models\AssignTasks;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->session->timeout = Yii::$app->params['sessionTimeoutSeconds'];
        }

        return parent::beforeAction($action);
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['site/login']);
    }

    public function actionDashboard()
    {
        // Check if the user is a guest before accessing identity
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // Load the model with the existing image path
        $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $tasks = AssignTasks::find()->where(['employee_id' => Yii::$app->user->identity->id])->all();
        return $this->render('dashboard', [
            'model' => $model,
            'tasks' => $tasks
        ]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post()['LoginForm']['username'] !== 'admin' && $model->login()) {
            Yii::$app->session->setFlash('success', 'Login Successfully');
            return $this->redirect(['site/dashboard']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            // echo '<pre>'; print_r('hii');exit();
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['site/signup']);
        } else {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionApplyLeave()
    {
        $model = new LeaveApplications();

        if (Yii::$app->request->isPost && !empty(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->leave_type = Yii::$app->request->post()['User']['leaveType'];
            $model->start_date = Yii::$app->request->post()['User']['startDate'];
            $model->end_date = Yii::$app->request->post()['User']['endDate'];
            $model->reason = Yii::$app->request->post()['User']['reason'];
            $model->status = 0;

            if ($model->save(false)) {
                // Set a success flash message
                Yii::$app->session->setFlash('success', 'Leave application submitted successfully.');
            } else {
                // Set an error flash message
                Yii::$app->session->setFlash('error', 'Failed to submit leave application.');
            }
        }

        return $this->redirect(['site/dashboard']);
    }

    public function actionLeaveForm()
    {
        $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        return $this->render('leaveForm', ['model' => $model]);
    }

    // ...

    public function actionEdit($id, $userId)
    {
        $model = LeaveApplications::findOne(['id' => $id, 'user_id' => $userId]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested record does not exist.');
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->save(false); // Use save(false) to skip validation for simplicity

            Yii::$app->session->setFlash('success', 'Leave application updated successfully.');
            return $this->redirect(['site/dashboard']);
        }

        return $this->render('editLeave', ['model' => $model]);
    }

    public function actionDelete($id, $userId)
    {
        $customer = LeaveApplications::findOne(['id' => $id, 'user_id' => $userId]);
        $customer->delete();
        Yii::$app->session->setFlash('success', 'Leave application cancel successfully.');
        return $this->redirect(['site/dashboard']);
    }

    public function actionUpload()
    {
        $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload()) {
                // File is uploaded successfully, you can redirect or render your desired view
                Yii::$app->session->setFlash('success', 'Image Upload Successfully');
                return $this->redirect(['site/dashboard']);
            } else {
                Yii::$app->session->setFlash('error', 'Image Not Uploaded');
                return $this->redirect(['site/dashboard']);
            }
        }

        // If there is an error or the upload fails, render the dashboard view with the model
        return $this->render('dashboard', ['model' => $model]);
    }

    public function actionUpdateStatus()
    {
        $statusValue = Yii::$app->request->post('statusValue');
        $id = Yii::$app->request->post('id');

        $model = AssignTasks::findOne($id); // Replace $id with the actual model ID
        if ($model) {
            $model->status = $statusValue;
            $model->save(false);

            // Return a success response
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        } else {
            // Return an error response as the model is not found
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'error' => 'Task not found.'];
        }
    }

    public function actionDownloadPdf($id)
    {
        $model = AssignTasks::findOne($id);
        
        if ($model && $model->attachment) {
            $filePath = Yii::getAlias('@backend/web') . '/' . $model->attachment;

            if (file_exists($filePath)) {
                Yii::$app->response->sendFile($filePath, $model->attachment, ['inline' => false])->send();
                return;
            }
        }

        throw new NotFoundHttpException('The requested PDF file does not exist.');
    }
}
