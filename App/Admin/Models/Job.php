<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/29/2018
 * Time: 2:17 PM
 */

namespace App\Admin\Models;
use PDO;
use App\Admin\Models\Staff as ModelStaff;

class Job extends \Core\Model
{

    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data = []) {

        foreach ($data as $key => $value) {

            $this->$key = $value;

        };

    }




    /**
     * @return mixed
     */

    public static function  findAll(){

        $sql = "SELECT * FROM job_category";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function categoryByPosition($id){


        $sql = "SELECT category_name FROM job_category WHERE category_id = :id ";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }


}