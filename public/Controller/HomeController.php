<?php




use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

require __DIR__ . '/../Conexao/Conexao.php';


final class HomeController
{



  public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $sql = "SELECT * FROM clientes";
    $db = new Conexao();
    try {
      $cnx = $db->conectar();
      $result = $cnx->query($sql);
      $clientes = $result->fetchAll(PDO::FETCH_OBJ);

      $cnx = null;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $response->getBody()->write(json_encode($clientes, JSON_UNESCAPED_UNICODE));
    return $response;
  }

  public function pesquisar(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args["id"];
    $sql = "SELECT * FROM clientes WHERE id=$id";
    $db = new Conexao();
    try {
      $cnx = $db->conectar();
      $result = $cnx->query($sql);
      $cliente = $result->fetchAll(PDO::FETCH_OBJ);

      $cnx = null;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $response->getBody()->write(json_encode($cliente, JSON_UNESCAPED_UNICODE));
    return $response;
  }

  public function salvar(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $body = $request->getParsedBody();
    $data = date('d-m-Y');
    $nome = $request->getParsedBody()["nome"];
    $telefone = $request->getParsedBody()["telefone"];
    $email = $request->getParsedBody()["email"];
    $cep = $request->getParsedBody()["cep"];

    $sql = "INSERT INTO clientes (data,nome,telefone,email,cep) VALUES (:data,:nome,:telefone,:email,:cep)";

    $db = new Conexao();
    try {
      $cnx = $db->conectar();
      $pstm = $cnx->prepare($sql);
      $pstm->bindParam(":data", $data);
      $pstm->bindParam(":nome", $nome);
      $pstm->bindParam(":telefone", $telefone);
      $pstm->bindParam(":email", $email);
      $pstm->bindParam(":cep", $cep);

      $result = $pstm->execute();
      $cnx = null;

      $response->getBody()->write(json_encode($body, JSON_UNESCAPED_UNICODE));
      return $response;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }

  public function editar(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $body = $request->getParsedBody();
    $id = $args['id'];
    $nome = $request->getParsedBody()["nome"];
    $telefone = $request->getParsedBody()["telefone"];
    $email = $request->getParsedBody()["email"];
    $cep = $request->getParsedBody()["cep"];

    $sql = "UPDATE clientes SET nome=:nome,telefone=:telefone,email=:email,cep=:cep WHERE id=:id";

    $db = new Conexao();
    try {
      $cnx = $db->conectar();
      $pstm = $cnx->prepare($sql);
      $pstm->bindParam(":nome", $nome);
      $pstm->bindParam(":telefone", $telefone);
      $pstm->bindParam(":email", $email);
      $pstm->bindParam(":cep", $cep);
      $pstm->bindParam(":id", $id);

      $result = $pstm->execute();
      $cnx = null;

      $response->getBody()->write(json_encode($body, JSON_UNESCAPED_UNICODE));
      return $response;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }

  public function deletar(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $sql = "DELETE FROM clientes WHERE id=:id";
    $db = new Conexao();
    try {
      $cnx = $db->conectar();
      $pstm = $cnx->prepare($sql);
      $pstm->bindParam(":id", $id);
      $pstm->execute();
      $cnx = null;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
    $response->getBody()->write("Sucesso!");
    return $response;
  }
}
