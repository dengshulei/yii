<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\HeadersAlreadySentException;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
    public $condition;
    public $value;
    public $ids;
    public $all_type;   // 0没有全选，1选择当前页，2选择全部搜索结果
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value', 'all_type'], 'integer'],
            [['name', 'code', 't_status', 'condition', 'ids'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = self::find();
        $params= Yii::$app->getRequest()->getQueryParams(); //接受全部 GET 参数
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['per-page']) ? $params['per-page'] : 10,
            ],
        ]);
        //var_dump($dataProvider->getModels());die();
        $dataProvider->setSort(false);
        /*
        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC]
                ],
                /*
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC]
                ],
            ],
            //默认排序，这里id一定需要在上面定义过的
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
        ]);
        */
        if (!$this->validate()) {
            return $dataProvider;
        }
        //支持搜索
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 't_status', $this->t_status]);
        if ($this->condition && $this->value) {
            $condition = '=';
            switch ($this->condition) {
                case 'gt' :
                    $condition = '>';
                    break;
                case 'lt' :
                    $condition = '<';
                    break;
                case 'ge' :
                    $condition = '>=';
                    break;
                case 'le' :
                    $condition = '<=';
                    break;
                case 'eq' :
                    $condition = '=';
                    break;
                case 'ne' :
                default :
                    $condition = '!=';
                    break;
            }
            $query->andFilterWhere([$condition, 'id', $this->value]);
        }
        return $dataProvider;
    }

    public function export()
    {
        $filename = date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment;filename={$filename}");
        ob_start();
        $fp = fopen('php://output', 'w');

        fwrite($fp,chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($fp, ['id', 'name', 'code', 't_status']);

        $dataProvider = $this->search();
        if ($this->all_type == 0) {
            //按选中的ID下载
            $ids = explode(',', $this->ids);
            $dataProvider->query->andFilterWhere(['IN', 'id', $ids]);
        }

        $model = $dataProvider->getModels();
        //var_dump($model);exit;
        foreach ($model as $v) {
            fputcsv($fp, [$v->id, $v->name, $v->code, $v->t_status]);
        }
        fclose($fp);
        return ob_get_clean();
    }
}
