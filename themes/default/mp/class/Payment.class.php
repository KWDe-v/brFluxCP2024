<?php

 class Payment{
    private $pdo;

    private $user_id = NULL;

    public $payment_id = NULL;

 public function __construct($user_id = NULL){

      $this->user_id   = $user_id;

      $this->pdo = DB::getInstance();

  }

  public function get(){
    $query = $this->pdo->prepare("SELECT * FROM `payment` WHERE id= :id");
    $query->bindValue(':id', $this->payment_id);

    if($query->execute()){

       $row = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($row)>0){
            return $row[0];
        }else{
            return false;
        }

    }else{
        return false;
    }
  }

public function addPayment($valor, $tipo = null){
    $query = $this->pdo->prepare("INSERT INTO payment (valor, user_id, tipo) VALUES (:valor, :user_id, :tipo)");
    $query->bindValue(':valor', $valor);
    $query->bindValue(':user_id', $this->user_id);
    $query->bindValue(':tipo', $tipo);

    if($query->execute()){
        return $this->pdo->lastInsertId();     
    }else{
        return false;
    }  
}
public function addPaymentForExistingOrder($valor, $tipo = null, $id){
    // Verificar se já existe um pagamento para o mesmo pedido
    $query_check = $this->pdo->prepare("SELECT id FROM payment WHERE id = :id");
    $query_check->bindValue(':id', $id);
    $query_check->execute();
    $existing_payment = $query_check->fetch(PDO::FETCH_ASSOC);

    if($existing_payment) {
        date_default_timezone_set('America/Sao_Paulo');

        $data = new DateTime(); // Data e hora atual
        $dataFormatada = $data->format('Y-m-d H:i:s'); // Formatação da data

        $payment_id = $existing_payment['id'];

        $query_update = $this->pdo->prepare("UPDATE payment SET created = :data, valor = :valor, tipo = :tipo WHERE id = :payment_id");
        $query_update->bindValue(':data', $dataFormatada);
        $query_update->bindValue(':valor', $valor);
        $query_update->bindValue(':tipo', $tipo);
        $query_update->bindValue(':payment_id', $payment_id);

        if($query_update->execute()) {
            return $payment_id; // Retorna o ID do pagamento existente
        } else {
            return false;
        }
    } else {
        // Se não existe um pagamento para o mesmo pedido, retornar false
        return false;
    }
}


public function setStatusPayment($status){
    $query = $this->pdo->prepare("UPDATE `payment` SET status= :status WHERE id= :id ");
    $query->bindValue(':status', $status);
    $query->bindValue(':id', $this->payment_id);

    if($query->execute() && $status === 'approved'){
        // Seleciona as informações user_id e valor da tabela payment
        $selectQuery = $this->pdo->prepare("SELECT user_id, valor, tipo FROM `payment` WHERE id= :id");
        $selectQuery->bindValue(':id', $this->payment_id);
        $selectQuery->execute();
        $paymentData = $selectQuery->fetch(PDO::FETCH_ASSOC);

        // Verifica se o user_id já existe na tabela payment_data
        $checkQuery = $this->pdo->prepare("SELECT COUNT(*) FROM `payment_data` WHERE user_id = :user_id");
        $checkQuery->bindValue(':user_id', $paymentData['user_id']);
        $checkQuery->execute();
        $userExists = $checkQuery->fetchColumn();

        // Se o user_id já existe, atualiza apenas o valor, caso contrário, insere os dados normalmente
        if($userExists){
            $updateQuery = $this->pdo->prepare("UPDATE `payment_data` SET valor = valor + :valor, tipo = :tipo WHERE user_id = :user_id");
            $updateQuery->bindValue(':valor', $paymentData['valor']);
			$updateQuery->bindValue(':tipo', $paymentData['tipo']);
            $updateQuery->bindValue(':user_id', $paymentData['user_id']);
            return $updateQuery->execute();
        } else {
            $insertQuery = $this->pdo->prepare("INSERT INTO payment_data (user_id, valor, tipo) VALUES (:user_id, :valor, :tipo)");
            $insertQuery->bindValue(':user_id', $paymentData['user_id']);
            $insertQuery->bindValue(':valor', $paymentData['valor']);
			$insertQuery->bindValue(':tipo', $paymentData['tipo']);
            return $insertQuery->execute();
        }
    } else {
        return false;
    }
}

 }

 ?>
