<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Atributos
    // Base de Datos
    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    protected $id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $password;
    protected $telefono;
    protected $admin;
    protected $confirmado;
    protected $token;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->admin = $args["admin"] ?? "0";
        $this->confirmado = $args["confirmado"] ?? "0";
        $this->token = $args["token"] ?? "";
    }

    // Metodos
    // Validamos la nueva cuenta a crear
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El Nombre es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = "El Apellido es Obligatorio";
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = "El Telefono es Obligatorio";
        }
        if (!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "La Contraseña debe tener al menos 6 caracteres";
        }
        return self::$alertas;
    }

    // Validamos el inicio de sesion
    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }

        return self::$alertas;
    }

    // Validar el email para el olvide password
    public function validarEmail() { 
        if (!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
        
        return self::$alertas;
    }

    // Validar el password para el olvide password
    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "La Contraseña debe tener al menos 6 caracteres";
        }

        return self::$alertas;
    }
    
    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas["error"][] = "El Usuario ya esta registrado";
        }
        
        return $resultado;
    }

    // Hashea el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Genera un Token unico para el Usuario
    public function crearToken() {
        $this->token = uniqid();
    }

    // Confirma que el password y el usuario este verificado
    public function comprobarPasswordYVerificado($password) {
        // Verificamos la contraseña
        $resultado = password_verify($password, $this->password);
        // El usuario o no esta verificado o la contraseña esta mal
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = "Password Incorrecto o tu cuenta no ha sido confirmada";
        }
        // El usuario esta verificado y la contraseña esta bien
        else {
            return true;
        }
    }

    // ----------- //
    // Get y Set
    // Get de id
    public function getId() : string {
        return $this->id;
    }
    // Get de nombre
    public function getNombre() : string {
        return $this->nombre;
    }
    // Get de apellido
    public function getApellido() : string {
        return $this->apellido;
    }
    // Get de email
    public function getEmail() : string {
        return $this->email;
    }
    // Get de password
    public function getPassword() : string {
        return $this->password;
    }
    // Get de telefono
    public function getTelefono() : string {
        return $this->telefono;
    }
    // Get de token
    public function getToken() : string {
        return $this->token;
    }
    // Get de admin
    public function getAdmin() : string {
        return $this->admin;
    }
    // Get de confirmado
    public function getConfirmado() : string{
        return $this->confirmado;
    }
    // Set de token
    public function setToken($token) : void {
        $this->token = $token;
    }
    // Set de confirmado
    public function setConfirmado($confirmado) : void {
        $this->confirmado = $confirmado;
    }
    // Set de password
    public function setPassword($password) : void {
        $this->password = $password;
    }
}