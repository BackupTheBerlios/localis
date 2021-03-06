<?php


if (!is_file(PROOT."db/local.php")) {
	header('Location: install.php');
	exit;
}

include PROOT."db/local.php";

$db = new db($dbhost,$dbport,$dbname,$dbuser,$dbpass) or die("pb a la creation de l'objet db !");;

if (!$db->conn) {
	$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
}

class db {

	var $conn;
	var $mes = array();
	var $connstr;

	function db($host='',$port='',$name='',$user='',$pass='') {

		$str = array();
		if ($host) $str[] = "host=$host";
		if ($port) $str[] = "port=$port";
		if ($name) $str[] = "dbname=$name";
		if ($user) $str[] = "user=$user";
		if ($pass) $str[] = "password=$pass";
		$this->connstr = implode(' ',$str);
//		echo $this->connstr;
		$this->conn =  pg_connect($this->connstr);
		if (!$this->conn) {
			$this->mes[] = tra("Connection � la base impossible.");
		}
	}

	function report() {
		$ret = array();
		$ret['options'] = pg_options($this->conn);
		return $ret;
	}

	function strip_array($a) {
		$ret = array();
		foreach($a as $k=>$v) {
			$k = stripslashes($k);
			$ret[$k] = stripslashes($v);
		}
		return $ret;
	}

	function s_query($query) { // simple query
		return (pg_query($this->conn,$query));
	}
	
	function query($query,$return=false) {
		$result = @ pg_query($this->conn,$query);
		$ret = array();
		if (!$result) {
			$this->mes[] = "xx : db request error<br /><b>$query</b><br />". @ pg_last_error();
			return false;
		}
		if ($return) {
			$rows = pg_num_rows($result);
			for ($i = 0; $i < $rows; $i++) {
				$ret[] = pg_fetch_assoc($result);
				//$ret[] = $this->strip_array(pg_fetch_array($result, $i, PGSQL_ASSOC));
			}
			return $ret;
		} else {
			return true;
		}
	}

	function queryone($query) {
		$res = $this->query($query,true);
		if ($res and $res[0]) {
			return $this->strip_array($res[0]);
		} else {
			return false;
		}
	}

	function getone($query) {
		$res = $this->query($query,true);
		if ($res and isset($res[0])) {
			$it = array_shift($res[0]);
			return stripslashes($it);
		} else {
			return false;
		}
	}

	/* ======== U S E R admin methods  ======= */
	
	function errorlogin($login,$pass) {
		$login = addslashes($login);
		$hash = $this->queryone("select pass,credential from users where login='$login'");
		if ($hash and is_array($hash)) {
			if ($hash['pass'] == md5($pass)) {
				$_SESSION['me'] = $login;
				$_SESSION['profile']=$hash['credential'];
				if ($hash['credential'] == 19230) {
					$_SESSION['admin'] = true;
				} else {
					$_SESSION['admin'] = false;
				}
				return false;
			} else {
				return tra("Mot de passe incorrect");
			}
		} else {
			return tra("Identifiant inconnu.");
		}
	}

	function list_users($offset=0,$limit=0,$find='') {
		$more = '';
		if ($find) {
			$more.= " where login like '%$find%'";
		}
		if ($limit) {
			if ($limit == '-1') $limit = 'all';
			$more.= " limit $limit";
			if ($offset) $more.= " offset $offset";
		}
		$query = "select *, oid from users $more";
		return $this->query($query,true);
	}

	function get_user($login) {
		$login = addslashes($login);
		$query = "select * from users where login='$login'";
		return $this->queryone($query);
	}

	function add_user($login,$pass,$mail,$bio,$credential=0) {
		$login = addslashes(trim($login));
		$pass = trim($pass);
		$mail = addslashes(trim($mail));
		$bio = addslashes(trim($bio));
		if ($login and $pass) {
			if ($this->getone("select count(*) from users where login='$login'") > 0) {
				$this->mes[] = "Ce login est d�j� utilis�, merci d'en choisir un autre";
				return false;
			}
			$query = "insert into users (login,pass,email,bio,credential) values('$login',md5('$pass'),'$mail','$bio',$credential)";
			return $this->query($query);
		} else {
			$this->mes[] = "One or more fields lacking";
			return false;
		}
	}

	function del_user($login) {
		$query = "delete from users where login='$login'";
		return $this->query($query);
	}
	
	function mod_user($login,$pass,$email,$bio,$credential=0) {
		$login = addslashes(trim($login));
    $pass = trim($pass);
		if ($pass) {
			$addpass = "pass=md5('$pass'),";
		} else {
			$addpass = '';
		}
    $mail = addslashes(trim($email));
    $bio = addslashes(trim($bio));
		$query = "update users set login='$login',".$addpass."email='$email',bio='$bio',credential=$credential where login='$login'";
    return $this->query($query);
	}

	function change_credential($login,$cred) {
		$query = "update users set credential=$cred where login='$login'";
    return $this->query($query);
	}	

	/* ======== conf admin methods  ======= */

  function list_confs($offset=0,$limit=0,$find='') {
    $more = '';
    if ($find) {
      $more.= " where name like '%$find%'";
    }
    if ($limit) {
      if ($limit == '-1') $limit = 'all';
      $more.= " limit $limit";
      if ($offset) $more.= " offset $offset";
    }
    $query = "select *, oid from conf $more";
    return $this->query($query,true);
  }

  function get_conf($name) {
    $name = addslashes($name);
    $query = "select * from conf where name='$name'";
    return $this->queryone($query);
  }

  function mod_conf($name,$value) {
    $name = addslashes(trim($name));
    $value = addslashes(trim($value));
    if ($name) {
      if ($this->getone("select count(*) from conf where name='$name'") > 0) {
        $query = "update conf set value='$value' where name='$name'";
        return $this->query($query);
      } else { 
        $query = "insert into conf (name,value) values('$name','$value')";
        return $this->query($query);
      }
    } else {
      $this->mes[] = tra("Aucune variable indiqu�e");
      return false;
    }
  } 

  function del_conf($name) {
    $query = "delete from conf where name='$name'";
    return $this->query($query);
  }

	/* ======== parcours methods  ======= */

	function add_parcours($name,$user,$discp,$geom,$level=0,$time=0,$marqimp="toto") {
		if ($marqimp=="toto") $marqimp=date('d-m-y');
		$line = implode(",",$geom);
		$user_id=RecupLib("users","login","user_id",$user);
		if (!$user_id) $user_id=1;
		$query = "insert into parcours (parcours_name,parcours_user,parcours_uscrea,parcours_discp,parcours_geom,parcours_level,parcours_time,parcours_dtcrea,parcours_marqimp) values ";
		$query.= "('". addslashes($name)."','". addslashes($user)."' , $user_id , '". addslashes($discp). "',GeomFromEWKT('SRID=-1;LINESTRING($line)'),'". addslashes($level)."',$time, '".date('Y-m-d')."', '$marqimp');";
		$resins=$this->s_query($query);
		if (!$resins) {
			$this->mes[] = "Requete: $query \n error: ". pg_last_error();
			return false;
		} else {
			if ($_SESSION['vitmoy']==0 || $_SESSION['vitmoy']=="") $_SESSION['vitmoy']=80; // 80=~ 5km/h
			$last_oid=pg_last_oid($resins);
			$query = "update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($_SESSION['vitmoy']*1000).") where parcours.oid=".pg_last_oid($resins).";";
			//echo $query;
			$resup=$this->s_query($query);
			if (!$resup) {
				$this->mes[] = "Requete: $query \n error: ". pg_last_error();
				return false;
			} else return true;
		}
	}
/* ======== info methods  ======= */
	function get_cities($name,$list_dpts="") { // passer la liste des depts de la r�gion en tre () ep par des ,
		$name = strtolower(addslashes(trim($name)));
		$query = "select nom,code_postal,id from communes where (lower(nom) like '%$name%' or lower(maj) like '%$name%') ".($list_dpts ? " AND floor(code_postal/1000) IN $list_dpts" : "");
		return $this->query($query,true);
	}
	
	function get_city_info($idcity) {
		$query = "select nom,code_postal,astext(coord) as xy from communes where id='$idcity'";
		return $this->query($query,true);
	}

	function get_parcours($ex) {
		$query = "select parcours_id,parcours_name,parcours_discp,AsText(parcours_start) as coord from parcours";
		//$query.= " where parcours_start && GeomFromText('POLYGON(($ex[0] $ex[1],$ex[0] $ex[3],$ex[2] $ex[3],$ex[0] $ex[1]))',-1)";
		$query.= " where parcours_geom && GeomFromText('POLYGON(($ex[0] $ex[1],$ex[0] $ex[3],$ex[2] $ex[3],$ex[0] $ex[1]))',-1)";
		
		if (isset($_SESSION['filtre'])) {
			$wh = array();
			foreach ($_SESSION['filtre'] as $k=>$v) {
				if (!empty($v)) {
					$v = addslashes($v);
					if ($k == "name") {
						$wh[] = "lower(parcours_$k) LIKE lower('%$v%')";
						}
					else $wh[] = "parcours_$k='$v'";
				}
			}
			if (count($wh)) {
				$where.= " and ". implode(' and ',$wh);
			}
			
		}
		if (!($_SESSION['admin'] || $_SESSION['profile']=="1")) $where.=" AND parcours_ouvert=true";
		$_SESSION['where_parc']=substr($where,5);
		$query.= $where;
		return $this->query($query,true);
	}

	function get_parcours_info($id) {
		$query = "select *,asText(Envelope(parcours_geom)) as ext from parcours where parcours_id=$id";
		return $this->queryone($query,true);
	}
	
	function get_lei_pts($ex) {
		$query = "select lei_f_id,lei_f_idcat,lei_f_libelle,AsText(lei_f_pos) as coord from lei_fiches";
		$query.= " where (lei_f_pos && GeomFromText('POLYGON(($ex[0] $ex[1],$ex[0] $ex[3],$ex[2] $ex[3],$ex[0] $ex[1]))',-1)) AND ($ex[4])";
		return $this->query($query,true);
	}	
}


?>
