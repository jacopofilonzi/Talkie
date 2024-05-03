<?php
/*
 * Classe con metodo pubblico per avere la connessione al DB
 * MySQLi Extension fornisce un'interfaccia con i database MySQL
 *
 * binding (tipi di bind  i = int, d = float, s = string, b = blob) 
 */

class Database
{
	// credenziali
	static private $host = "localhost";
	static private $db_name = "talkie";
	static private $username = "root";
	static private $password = "root";
	static private $authenticated = false;
	static private $conn = null;

	// connessione al database
	static public function SetConnection()
	{
		// crea connessione
		Database::$conn = new mysqli(Database::$host, Database::$username, Database::$password, Database::$db_name);
		//mysql_set_charset('utf8');
		Database::$conn->set_charset('utf8mb4');
		Database::$conn->query("SET CHARACTER SET utf8");
		Database::$conn->query("SET NAMES utf8");

		// controlla connessione
		if (Database::$conn->connect_error)
			die("Errore connessione DB: " . Database::$conn->connect_error);
		else
			Database::$authenticated = true;

		// connessione stabilita
		return Database::$conn;
	}

	static public function GetConnection()
	{
		if (is_null(Database::$conn))
			Database::SetConnection();

		return Database::$conn;
	}

	static public function CloseConnection()
	{
		Database::$conn->close();
		Database::$conn = null;
		Database::$authenticated = false;
	}

	static public function ExecuteQuery($query, $params, $types = null, &$error = null)
	{
		$conn = Database::GetConnection();

		//Prepara la query
		$stmt = $conn->prepare($query);

		// var_dump($params);

		if ($stmt === false) {
			die("Errore di preparazione query: " . $conn->error);
		}


		//Allega i parametri solamente se ci sono
		if (!empty($params)) {
			//Se ho specificato i parametri
			if (!is_null($types)) {
				//Se ho specificato i tipi dei parametri
				$stmt->bind_param($types, ...$params);
			} else {
				//Ipotizza siano tutti stringhe
				$types = str_repeat("s", count($params));
				$stmt->bind_param($types, ...$params);
			}
		}


		//Esegue la query
		$stmt->execute();


		// Verifica se si sono verificati errori durante l'esecuzione della query
		if ($stmt->errno) {
			$error = $stmt->error;
		}

		// Resto del codice...
		
		//Se la query è un insert ritorna l'id dell'ultimo record inserito
		if (strpos($query, "INSERT") !== false) {
			$insert_id = $conn->insert_id;


			$stmt->close();
			
			Database::CloseConnection();

			return $insert_id;
		}

		//Se la query è un select ritorna il risultato
		if (strpos($query, "SELECT") !== false) {
			$result = $stmt->get_result();
			$rows = array();
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}

			$stmt->close();
			Database::CloseConnection();
			return $rows;
		}

		//Se la query è un update o delete o replace ritorna il numero di righe modificate
		if (strpos($query, "UPDATE") !== false || strpos($query, "DELETE") !== false || strpos($query, "REPLACE") !== false) {
			$stmt->close();
			Database::CloseConnection();
			return $stmt->affected_rows;
		}


		//Se la query è un alter o drop o truncate o create ritorna true
		if (strpos($query, "ALTER") !== false || strpos($query, "DROP") !== false || strpos($query, "TRUNCATE") !== false || strpos($query, "CREATE") !== false) {
			$stmt->close();
			Database::CloseConnection();
			return true;
		}


		return false;
		
	}

	static public function OnlyAuthenticated()
	{
		return Database::$authenticated;
	}
}
