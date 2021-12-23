<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


final class Autenticacao{


    public function __invoke(Request $request,RequestHandlerInterface $handler)
    {
        $token = str_replace("Bearer ","",(string) $request->getHeaderLine("Authorization"));
        try{
        $jwt = JWT::decode($token,new Key(getenv("SECRET_KEY"),"HS256"));
        if(!$token){
            $response = new Response();
            $response->getBody()->write(json_encode(["auth"=>false,"token"=>null]));
            return $response->withHeader("content-type","application/json")->withStatus(302);
            
        }else{
            $response = $handler->handle($request);
            return $response->withHeader("content-type","application/json")->withStatus(200);

        }
        }catch(Exception $ex){
            $response = new Response();
            $response->getBody()->write(json_encode(["auth"=>false,"token"=>null,"erro"=>$ex->getMessage()]));
            return $response->withHeader("content-type","application/json")->withStatus(302);

        }
        
    } 
}
