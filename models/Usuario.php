<?php
    class Usuario{
        //database
        private $conn;
        private $tabela = 'usuario';

        //atributos
        public $id;
        public $nome;
        public $telefone;
        public $email;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->tabela . ' (nome, telefone, email)
            VALUES
                (?,?,?)';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));
            // Bind data
            $stmt->bindParam(1, $this->nome);
            $stmt->bindParam(2, $this->telefone);
            $stmt->bindParam(3, $this->email);
            // Execute query
            if($stmt->execute()) {
              return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
      }

        public function read(){
            $query = 'SELECT
                id, 
                nome,
                telefone,
                email
            FROM '.$this->tabela;

        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
        }

        public function read_single(){
            $query = 'SELECT
                id,
                nome,
                telefone,
                email
            FROM '.$this->tabela .
            ' Where 
            id = ?
            LIMIT 0,1';

            $stmt = $this->conn->prepare($query);
          // Bind ID
          $stmt->bindParam(1, $this->id);
          // Execute query
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          // Set properties
          $this->nome = $row['nome'];
          $this->telefone = $row['telefone'];
          $this->email = $row['email'];
        }

        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->tabela . '
                                  SET nome = :nome, telefone = :telefone, email = :email
                                  WHERE id = :id';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->id = htmlspecialchars(strip_tags($this->id));
            // Bind data
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':telefone', $this->telefone);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':id', $this->id);
            // Execute query
            if($stmt->execute()) {
              return true;
            }
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
      }

      public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE id = :id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        // Execute query
        if($stmt->execute()) {
          return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
  }
    }