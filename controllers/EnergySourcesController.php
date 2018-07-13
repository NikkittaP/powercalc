<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use app\models\ArchitecturesNames;
use app\models\EnergySources;
use app\models\EnergySourcesSearch;
use app\models\EnergySourceToArchitecture;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnergySourcesController implements the CRUD actions for EnergySources model.
 */
class EnergySourcesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EnergySources models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EnergySourcesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $energySourceToArchitecture = [];
        $energySources = EnergySources::find()->all();
        $architecturesNames = ArchitecturesNames::find()->all();
        foreach ($energySources as $energySource) {
            foreach ($architecturesNames as $architectureName) {
                $flag = 0; // 0 - Пустое. 1 - Частично заполненное. 2 - Заполненное

                $energySourceToArchitectureModel = EnergySourceToArchitecture::find()->where(['energySource_id' => $energySource->id, 'architectureName_id' => $architectureName->id])->one();
                if ($energySourceToArchitectureModel === null) {
                    $energySourceToArchitectureModel = new EnergySourceToArchitecture();
                    $energySourceToArchitectureModel->energySource_id = $energySource->id;
                    $energySourceToArchitectureModel->architectureName_id = $architectureName->id;
                    $energySourceToArchitectureModel->save();

                    $flag = 0;
                } else {
                    if ($energySource->energySourceType_id == 1) {
                        if ($energySourceToArchitectureModel->qMax === null &&
                            $energySourceToArchitectureModel->pumpPressureNominal === null &&
                            $energySourceToArchitectureModel->pumpPressureWorkQmax === null)
                            $flag = 0;
                        else if ($energySourceToArchitectureModel->qMax === null ||
                            $energySourceToArchitectureModel->pumpPressureNominal === null ||
                            $energySourceToArchitectureModel->pumpPressureWorkQmax === null)
                            $flag = 1;
                        else
                            $flag = 2;
                    } else if ($energySource->energySourceType_id == 2 || $energySource->energySourceType_id == 3) {
                        if ($energySourceToArchitectureModel->qMax === null &&
                            $energySourceToArchitectureModel->pumpPressureNominal === null &&
                            $energySourceToArchitectureModel->pumpPressureWorkQmax === null &&
                            $energySourceToArchitectureModel->energySourceLinked_id === null &&
                            $energySourceToArchitectureModel->NMax === null)
                            $flag = 0;
                        else if ($energySourceToArchitectureModel->qMax === null ||
                            $energySourceToArchitectureModel->pumpPressureNominal === null ||
                            $energySourceToArchitectureModel->pumpPressureWorkQmax === null ||
                            $energySourceToArchitectureModel->energySourceLinked_id === null ||
                            $energySourceToArchitectureModel->NMax === null)
                            $flag = 1;
                        else
                            $flag = 2;
                    } else if ($energySource->energySourceType_id == 4) {
                        if ($energySourceToArchitectureModel->energySourceLinked_id === null &&
                            $energySourceToArchitectureModel->NMax === null)
                            $flag = 0;
                        else if ($energySourceToArchitectureModel->energySourceLinked_id === null ||
                            $energySourceToArchitectureModel->NMax === null)
                            $flag = 1;
                        else
                            $flag = 2;
                    }
                }

                $energySourceToArchitecture[$energySource->id][$architectureName->id] = $flag;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'architecturesNames' => $architecturesNames,
            'energySourceToArchitecture' => $energySourceToArchitecture,
        ]);
    }

    /**
     * Displays a single EnergySources model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EnergySources model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EnergySources();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnergySources model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EnergySources model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EnergySources model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EnergySources the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnergySources::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
