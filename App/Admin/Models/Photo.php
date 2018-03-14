<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/14/2018
 * Time: 6:54 PM
 */

namespace App\Admin\Models;


class Photo extends \Core\Model
{

    /**
     * @var $photo_filename name of the file
     */

    public $photo_filename;

    /**
     * @var $tmp_path temporary path of file
     */

    public $tmp_path;

    /**
     * @var $photo_type type of file
     */

    public $photo_type;

    /**
     * @var $photo_size size of the file
     */

    public $photo_size;

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Error messages for photo upload process
     *
     * @var array
     */

    public $upload_errors_array = [

            UPLOAD_ERR_OK         => "There is no error",
            UPLOAD_ERR_INI_SIZE   => "The upload file exceeds the upload_max_size directive",
            UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the max_file_size directive",
            UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded",
            UPLOAD_ERR_NO_FILE    => "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporery folder",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION  => "A PHP extension stopped to file upload"
    ];


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
     * Sets file and checks whether empty errors or not
     *
     *  @return true or false
     */

    public function setFile($file){

        if (empty($file) || !$file || !is_array($file)) {

            $this->errors[] = "No file was uploaded";
            return false;

        }elseif($file['error'] != 0){

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        }else{

            $this->photo_filename = basename($file['name']);
            $this->tmp_path       = $file['tmp_name'];
            $this->photo_type     = $file['type'];
            $this->photo_size     = $file['size'];

        }

        return false;

    }


    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */

    public function save() {
        return true;
    }



}