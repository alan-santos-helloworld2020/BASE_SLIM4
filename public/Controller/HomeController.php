<?php


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


final class HomeController{



      public function index(ServerRequestInterface $request,ResponseInterface $response, array $args): ResponseInterface
      {
        $response->getBody()->write(json_encode(["nome"=>"melão"],JSON_UNESCAPED_UNICODE));
        return $response;

      }

      public function pesquisar(ServerRequestInterface $request,ResponseInterface $response, array $args): ResponseInterface
      {
        $id = $args["id"];
        $response->getBody()->write(json_encode(["id"=>$id],JSON_UNESCAPED_UNICODE));
        return $response;

      }

      public function salvar(ServerRequestInterface $request,ResponseInterface $response, array $args): ResponseInterface
      {
        $body = $request->getParsedBody();
        $response->getBody()->write(json_encode($body,JSON_UNESCAPED_UNICODE));
        return $response;

      }

      public function editar(ServerRequestInterface $request,ResponseInterface $response, array $args): ResponseInterface
      {
        $id = $args["id"];
        $body = $request->getParsedBody();
        $response->getBody()->write(json_encode(["id"=>$id,"dados"=>$body],JSON_UNESCAPED_UNICODE));
        return $response;

      }

      public function deletar(ServerRequestInterface $request,ResponseInterface $response, array $args): ResponseInterface
      {
        $id = $args["id"];
        $response->getBody()->write(json_encode(["id"=>$id],JSON_UNESCAPED_UNICODE));
        return $response;

      }



}