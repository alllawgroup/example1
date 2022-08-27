<?php
class DbC 
{
//CREATE CONNECTION TO DB
private $host, $usr, $pwd, $dbn, $con;

public function __construct ($host="localhost", $usr = "root", $pwd = "root", $dbn = "db_test")
{
	$this->h = $host;
	$this->u = $usr;
	$this->p = $pwd;
	$this->d = $dbn;
}
//CONNECT TO DB 
public function connect()
{
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$this->con = new mysqli($this->h, $this->u, $this->p, $this->d);
	if (mysqli_connect_errno()){
		printf ("Неудачное подключение: %s\n", mysqli_connect_error());
		exit();
	}
} 
//SELECT DATA FROM DB 
//return fields:
public function selectall($lang)
{
    $llist = ['rus','eng','ger'];
	if (in_array($lang,$llist)){
	//SELECT COUNTRIES
 	$result = $this->con->query("SELECT 
	country.id as country_id, country.c_name_{$lang} as country, country.c_descr_{$lang} as country_dscr FROM country");
    for ($co = []; $row = mysqli_fetch_assoc($result); $co [] = [
	"country_id"=>$row['country_id'], 
	"country_name"=>$row['country'], 
	"country_descr"=>$row['country_dscr']
	]); 
    //SELECT REGIONS
    $result = $this->con->query("SELECT
	region.r_country_id as r_co_id, region.id as region_id, region.r_name_{$lang} as region, region.r_descr_{$lang} as region_dscr FROM region");
    for ($re = []; $row = mysqli_fetch_assoc($result); $re [] = [
	"region_id"=>$row['region_id'],
	"region_country"=>$row['r_co_id'], 
	"region"=>$row['region'],
	"region_dscr"=>$row['region_dscr']
	]);
	//SELECT SITIES
    $result = $this->con->query("SELECT
	city.c_country_id as ci_co_id, city.c_region_id as ci_re_id,city.c_name_{$lang} as city, city.c_descr_{$lang} as city_dscr FROM city");
    for ($ci = []; $row = mysqli_fetch_assoc($result); $ci [] = [
	"city_country_id"=>$row['ci_co_id'],
	"city_region_id"=>$row['ci_re_id'], 
	"city"=>$row['city'],
	"city_dscr"=>$row['city_dscr']
	]);	
	$coreci_list = self::makelist($co,$re,$ci);
    $result->close();
	return $coreci_list;
    }
	else{
	return null;
	}
}
//
private static function findregandci($co_id,$reg,$cit)
{
	$r = ""; 
 	foreach($cit as $c){
       if ($co_id === $c["city_country_id"] && $c["city_region_id"] === '0'){
		$r .= "<li class='city' data-info='{$c['city_dscr']}'>".$c["city"]."</li>";
	}  	 
	}
 	foreach($reg as $v){
    if ($co_id === $v["region_country"]){
		$r .= "<li class='region' data-info='{$v['region_dscr']}'>".$v["region"]."</li>";
	foreach ($cit as $ci){
	if ($ci['city_region_id'] === $v["region_id"]){
	    $r .= "<li class='city' data-info='{$ci['city_dscr']}'>".$ci["city"]."</li>";	
	}	
	}	
	}  	 
	}
	yield $r;
}
//
private static function makelist($co,$re,$ci)
{
	$corecilist = "";
 	for ($i=0;$i<count($co);$i++){
	    $corecilist .= "<p class='country' data-info='{$co[$i]['country_descr']}'>".$co[$i]['country_name']."</p>";
		foreach (self::findregandci($co[$i]['country_id'],$re,$ci) as $v){
		$corecilist .= $v;	
		}
	} 
    return $corecilist;	
}
}//END CLASS
?>