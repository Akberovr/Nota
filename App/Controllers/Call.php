<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use \Core\View;
use App\Models\Call as CallModel;
use App\Models\Navigation as NavigationModel;

class Call extends \Core\Controller {

    public function indexAction() {
        // Config
        $redirect = "http://localhost/sgi-google-sheets-api-append/tutorial-google-oauth-callback.php"; // Enter your API Callback URL here
        $client_id = "914656398258-g6evcoag7ihcqqurkt1scne07gu9a5kf.apps.googleusercontent.com"; // Enter your API Client ID Here
        $client_secret = "Aj06U52b1ZNtMPvSTKrzJkOS"; // Enter your API Client Secret here
        // Check Code
        if (empty($_GET['code'])) {
            // Authorization Link
            $authorization = "https://accounts.google.com/o/oauth2/auth?redirect_uri=$redirect&client_id=$client_id&response_type=code&scope=https://www.googleapis.com/auth/spreadsheets&approval_prompt=force&access_type=offline";
        } else {
            // Authorization
            $code = $_GET['code'];
            // Token
            $url = "https://accounts.google.com/o/oauth2/token";
            $data = "code=$code&client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect&grant_type=authorization_code";
            // Request
            $ch = @curl_init();
            @curl_setopt($ch, CURLOPT_POST, true);
            @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            @curl_setopt($ch, CURLOPT_URL, $url);
            @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/x-www-form-urlencoded'
            ));
            @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = @curl_exec($ch);
            $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
            @curl_close($ch);
            $array = json_decode($response);
        }

        View::renderTemplate('Call/index.html',[
            "navigation" => NavigationModel::getCategory()
        ]);
    }

}
