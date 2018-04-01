<?php

class Usuario{

	/* Atributos da classe */
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	// ----- Métodos de acesso aos atributos da classe ----- //
	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}

	// ----- Métodos internos de manipulação da classe ----- //
	/* Método construtor */
	public function __construct($deslogin = "", $dessenha = ""){
		$this->setDeslogin($deslogin);
		$this->setDessenha($dessenha);
	}

	/* Métodos sobrecarregados/ herdados */
	public function __toString(){
		return json_encode(array(
				"idusuario"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
	}

	/* Métodos próprios */
	public function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
	}

	// ----- Métodos de acesso ao banco ----- //
	/* Selecionar todos os usuários*/
	public static function selectAll():array{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY dtcadastro");
	}

	/* Selecionar lista de usuários baseado no login */
	public static function selectByLogin($login):array{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :search ORDER BY dtcadastro", array(
				':search'=>"%".$login."%"
			)
		);
	}

	/* Selecionar um usuário por ID*/
	public function selectById($id){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

		if(count($results) > 0) $this->setData($results[0]);
	}

	/* Inserir um usuário */
	public function insert(){
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha()
			));

		if(count($results) > 0) $this->setData($results[0]);
	}

	/* Atualizar um usuário*/
	public function update($deslogin, $dessenha){
		
		$this->setDeslogin($deslogin);
		$this->setDessenha($dessenha);

		$sql = new Sql();

		$results = $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha(),
				':ID'=>$this->getIdusuario()
			));
	}

	// ----- Métodos de ação - negócio ----- //
	/* Logar um usuário */
	public function login($login, $password){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and dessenha = :PASSWORD", array(":LOGIN"=>$login, ":PASSWORD"=>$password));

		if(count($results) > 0) $this->setData($results[0]);
		else{
			throw new Exception("Login e/ ou senha inválidos.",1);
		}
	}

	



}

?>