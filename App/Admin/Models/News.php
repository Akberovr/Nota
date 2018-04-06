<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 4/6/2018
 * Time: 1:53 PM
 */

namespace App\Admin\Models;

use PDO;
use App\Paginate;

class News extends \Core\Model
{


    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

    }


    public static function findAll(){

        $sql = "SELECT * FROM news";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    /**
     * Gets news with offset from database
     *
     * @return array
     */

    public static function getNews($page,$data_per_page,$class){

        $paginate = new Paginate($page,$data_per_page,$class);

        $sql = "SELECT * FROM news  LIMIT {$data_per_page} OFFSET {$paginate->offset()}";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }


    /**
     * @param $page number of pages
     * @param $data_per_page
     * @param $class Class that need to be paginated
     * @return float
     */

    public static function getPages($page,$data_per_page,$class)
    {

        $paginate = new Paginate($page,$data_per_page,$class);

        $pages = $paginate->totalPage(News::class);

        return $pages;

    }











}