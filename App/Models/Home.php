<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 5/2/2018
 * Time: 2:13 PM
 */

namespace App\Models;

use App\Admin\Models\News;

use PDO;

class Home extends \Core\Model
{

    /**
     * Class constructor
     *
     * @param array $data  Initial property values
     *
     * @return void
     */
    public function __construct($data=[])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Search news like inputted parameter
     * @param $param
     * @return array
     */

    public static function search ($param)
    {

        $sql = "SELECT * FROM news WHERE tags LIKE '%$param%'";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS,get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }


}