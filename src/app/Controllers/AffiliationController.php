<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class AffiliationController
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function check(Request $request, Response $response)
    {
        $credential = $request->getParsedBody();

        $sql = "SELECT
                    no_member,
                    nama,
                    email,
                    kota, 
                    apro AS code,
                    photo
                FROM tb_member 
                WHERE 
                    apro=:affiliation_code";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":affiliation_code" => $credential["aff"]
        ];

        $stmt->execute($data);

        if ($stmt->rowCount() > 0) {
            
            $refferal = $stmt->fetch();

            return $response->withJson(["status" => "success", "data" => $refferal], 200);
        }

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    }

}
