<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


final class UserController{

      public function login(Request $req,Response $res,$args){
          $body = $req->getParsedBody();
          if ($body["email"] === "fulano@gmail.com" && $body["password"] === "123") {
              $key = getenv("SECRET_KEY");
              $now_tyme = time();
              $payload=[
                  "iss"=>"alan@gmail.com",
                  "iat"=>$now_tyme,
                  "exp"=>$now_tyme+(60*2),
                  "uid"=>1

              ];
              $token = JWT::encode($payload,$key,"HS256");
              $res->getBody()->write(json_encode(["auth"=>true,"token"=>$token]));
              return $res->withHeader("content-type","application/json")->withStatus(201);
          }else{
            $res->getBody()->write(json_encode(["auth"=>false,"token"=>null]));
            return $res->withHeader("content-type","application/json")->withStatus(500);
          }





      }




}