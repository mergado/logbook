<?php
/**
 * Created by PhpStorm.
 * User: samuel
 * Date: 23.2.16
 * Time: 9:30
 */

namespace App\MergadoModels;


use App\Models\Query;
use App\Models\Rule;
use App\Models\RuleQuery;

class ProjectModel extends MergadoApiModel
{

//    protected $projectId;

    public $id;
    public $shop_id;
    public $creator_id;
    public $name;
    public $url;
    public $activated;
    public $created;
    public $exported_items;
    public $input_format;
    public $output_format;
    public $pairing_elements;
    public $read_only;
    public $rules_changed_at;
    public $sklik_context;
    public $sklik_search;
    public $slug;
    public $turned_off;
    public $update_period;
    public $last_access;
    public $xml_synced_at;
    public $xml_updated_at;
    public $type;

    const NEED_ID = true;

    public function __construct($projectId, $attributes = [], $token = null)
    {
        $this->id = $projectId;
        parent::__construct($attributes, $token);
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function get(array $fields = [])
    {
        $prepared = $this->api->projects($this->id);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        $fromApi = $prepared->get();

        $this->populate($fromApi);

        return $this;
    }


    public static function getTypefromApi($projectId)
    {
        $model = new static($projectId);

        $model->get(["output_format"]);

        return $model->getType();
    }

    public function getType()
    {
        $outputFormat = $this->output_format;

        switch ($outputFormat) {
            case preg_match('/\bfacebook?\b/', $outputFormat):
                return "facebook";
            case "heureka.cz":
                return "heureka";
            case "heureka.sk":
                return "heureka";
            case "zbozi.cz":
                return "zbozi";
            default:
                return null;
        }
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @return mixed
     */
    public function getQueries($limit = 10, $offset = 0, array $fields = [])
    {
        $prepared = $this->api->projects($this->id)->queries->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        $queries = $prepared->get()->data;

        $queries = QueryModel::hydrate($queries);

        return $queries;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @return mixed
     */
    public function getNamedQueries(array $fields = [])
    {
        $prepared = $this->api->projects($this->id)->queries->limit(300)->offset(0);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        $queries = $prepared->get()->data;

        $namedQueries = array_filter($queries, function ($query) {
            return !is_null($query->name);
        });

        $queries = QueryModel::hydrate($namedQueries);

        foreach ($queries as $query) {
            if ($query->name == "♥ALLPRODUCTS♥") {
                $query->name = trans('fie.all_products');
                break;
            }
        }

        return $queries;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @return mixed
     */
    public function getRules($limit = 10, $offset = 0, array $fields = [])
    {
        $prepared = $this->api->projects($this->id)->rules->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        $fromApi = $prepared->get()->data;

        $rules = RuleModel::hydrate($fromApi);

        return $rules;
    }

    /**
     * @param $rule
     * @param array $attributes (additional attributes that are save to local database)
     * @return mixed
     */
    public function createRule($rule, $attributes = [])
    {
        $fromApi = $this->api->projects($this->id)->rules()->post($rule);

        $newRule = new RuleModel($fromApi->id, $fromApi);

        $localRule = array_add((array)$fromApi, 'element_id', $newRule->project_element_id);
        $localRule = array_merge($localRule, $attributes);
        Rule::create($localRule);

        return $newRule;
    }

    public function createRuleWithQueries($rule, array $queries)
    {
        $fromApi = (object)$this->api->projects($this->id)->rules()->post($rule);

        $newRule = new RuleModel($fromApi->id, $fromApi);
        Rule::create(array_add((array)$newRule, 'element_id', $newRule->project_element_id));

        return $newRule;
    }

    public function createQuery($query, $tag = null)
    {
        $fromApi = $this->api->projects($this->id)->queries()->post($query);

        $newRule = new QueryModel($fromApi->id, $fromApi);

        if ($tag) {
            Query::create(array_merge((array)$newRule, ["tag" => $tag]));
        } else {
            Query::create((array)$newRule);
        }

        return $newRule;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @return mixed
     */
    public function getElements($limit = 10, $offset = 0, array $fields = [])
    {

        $prepared = $this->api->projects($this->id)->elements->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        return $prepared->get()->data;
    }

    public function createElement($element)
    {
        return $this->api->projects($this->id)->elements->post($element);
    }

    public function setOutputFormatAttribute($value)
    {
        $this->output_format = $value;
        $this->type = $this->getType();
    }

    public function fetchAndSaveAllProductsQuery()
    {
        $queries = $this->getQueries(200, 0);
        $allProducts = null;

        foreach ($queries as $query) {
            if ($query->name == "♥ALLPRODUCTS♥") {
                $allProducts = $query;
                break;
            }
        }

        if (!$allProducts) return false;

        Query::updateOrCreate([
            "id" => $allProducts->id,
            "name" => $allProducts->name,
            "project_id" => $allProducts->project_id,
            "query" => $allProducts->query,
            "read_only" => $allProducts->read_only,
            "search_output" => $allProducts->search_output,
            "tag" => "all"
        ]);

        return $allProducts;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @return mixed
     */
    public function getProducts($limit = 10, $offset = 0, array $fields = [])
    {
        $prepared = $this->api->projects($this->id)->products->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        return $prepared->get()->data;
    }

    /**
     * @param $projectId
     * @param int $limit
     * @param int $offset
     * @param array $fields
     * @param null $date
     * @return mixed
     */
    public function getAllProductsStats($limit = 10, $offset = 0, array $fields = [], $date = null)
    {
        $prepared = $this->api->projects($this->id)->stats->products->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        if ($date) {
            $prepared = $prepared->param("date", $date);
        }

        $stats = $prepared->get()->data;

        return $stats;
    }

    /**
     * @param $projectId
     * @param array $itemIds
     * @param array $fields
     * @param null $date
     * @return mixed
     */
    public function getAllProductsStatsByIds(array $itemIds = [], array $fields = [], $date = null)
    {
        $prepared = $this->api->projects($this->id)->stats->products;

        $postData = [];

        if (!empty($itemIds)) {
            $postData["filter_by"] = ["item_id__in" => $itemIds];
        }

        if (!empty($fields)) {
            $postData["fields"] = $fields;
        }

        if ($date) {
            $postData["date"] = $date;
        }

        $stats = $prepared->post($postData)->data;

        return $stats;
    }

    public function getGoogleAnalytics($limit = 10, $offset = 0, array $fields = [], $dimensions = [], $metrics = [], $startDate = null, $endDate = null)
    {
        $prepared = $this->api->projects($this->id)->google->analytics->limit($limit)->offset($offset);

        if (!empty($fields)) {
            $prepared = $prepared->fields($fields);
        }

        if ($startDate) {
            $prepared = $prepared->param("start_date", $startDate);
        }

        if ($endDate) {
            $prepared = $prepared->param("end_date", $endDate);
        }

        if ($dimensions) {
            $dimensions = implode(',', $dimensions);
            $prepared = $prepared->param("dimensions", $dimensions);
        }

        if($metrics) {
            $metrics = implode(',', $metrics);
            $prepared = $prepared->param("metrics", $metrics);
        }

        $analytics = $prepared->get()->data;

        return $analytics;
    }


}