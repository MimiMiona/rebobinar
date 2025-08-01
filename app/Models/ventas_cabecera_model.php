<?php
// Namespace donde se encuentra el modelo
namespace App\Models;
// Importamos la clase base Model de CodeIgniter
use CodeIgniter\Model;


// Definimos la clase Ventas_cabecera_model que extiende la clase Model de CodeIgniter
class Ventas_cabecera_model extends Model
{
    // Nombre de la tabla en la base de datos
	protected $table = 'ventas_cabecera';
    // Campo que es la clave primaria de la tabla
	protected $primaryKey = 'id';
	// Campos de la tabla que se pueden insertar o actualizar
    protected $allowedFields = ['fecha', 'usuario_id', 'total_venta'];

	public function getBuilderVentas_cabecera(){
        //Conecta a la base de datos usando el helper de configuración de CodeIgniter
        $db = \Config\Database::connect();

        //Crea un query builder sobre la tabla ventas_cabecera. Lo cual permite construir consultas SQL
        $builder = $db->table('ventas_cabecera');
        $builder->select('*'); //Se seleccionan todas las columnas

        // Se realiza un JOIN con la tabla usuarios usando la relación entre usuarios.id_usuario y ventas_cabecera.usuario_id.
        $builder->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');

        //Ejecuta la consulta y devuelve los resultados como un array asociativo
        $query = $builder->get();
        return $query->getResultArray();
    }

// Esta función devuelve las ventas según si se pasa o no un $id_usuario
    public function getVentas($id_usuario = null){
        //Si no se pasa un ID de usuario (es null)
        if ($id_usuario === null) {
            //La función getBuilderVentas_cabecera() devuelve el resultado de la consulta como array.
            return $this->getBuilderVentas_cabecera();
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('ventas_cabecera');
            $builder->select('*');
            $builder->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');
            $builder->where('ventas_cabecera.usuario_id', $id_usuario);
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}