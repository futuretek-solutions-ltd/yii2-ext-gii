<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use kartik\grid\GridView;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    public $defaultAction = 'index';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $this->assign('grid', GridView::widget([
        'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        'filterModel' => $searchModel,
        'responsive' => true,
        'toolbar' => [
            [
                'content' => Html::a('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', 'New'), //todo: Edit new button name
                    ['create'],
                    ['class' => 'btn btn-success', 'title' => Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', 'New')] //todo: Edit new button name
                )
            ],
            '{export}',
        ],
    'layout' => '<div class="row"><div class="col-md-4 pull-right text-right m-b-md">{toolbar}</div><div class="col-xs-12">{items}</div><div class="col-md-6">{summary}</div><div class="col-md-6"><div class="pull-right">{pager}</div></div></div>',
        'pjax' => true,
        'columns' => [
        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                if ($name === 'created_at' || $name === 'updated_at') continue;
                if ($name === 'id') { ?>
            [
                'class' => 'kartik\grid\DataColumn',
                'attribute' => 'id',
                'width' => '120px',
            ],
                <?php
                } else
                if (++$count < 6) {
                    echo "            '" . $name . "',\n";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                if ($column->name === 'created_at' || $column->name === 'updated_at') continue;
                if ($column->name === 'id') { ?>
            [
                'class' => 'kartik\grid\DataColumn',
                'attribute' => 'id',
                'width' => '120px',
            ],
                <?php
                } else
                if (++$count < 6) { ?>
                [
                    'attribute' => '<?= $column->name ?>',
                ],
                <?php
                }
            }
        }
        ?>
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} &nbsp; {delete}',
            ],
        ],
        'export' => [
            'label' => Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', 'Export'),
            'fontAwesome' => true,
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'filename' => Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>'),
            ],
            GridView::PDF => [
                'filename' => Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>'),
            ],
        ],
        ]));

        return $this->renderSmarty('index');
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        $this->assign([
            'dataProvider' => $dataProvider,
        ]);
        return $this->renderSmarty('index');
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView(<?= $actionParams ?>)
    {
        $this->assign([
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
        return $this->renderSmarty('view');
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the index page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        /** @noinspection NotOptimalIfConditionsInspection */
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $this->assign([
                'model' => $model,
            ]);
            return $this->renderSmarty('create');
        }
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the index page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        /** @noinspection NotOptimalIfConditionsInspection */
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $this->assign([
                'model' => $model,
            ]);
            return $this->renderSmarty('update');
        }
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('error', 'The requested page does not exist.'));
        }
    }
}
