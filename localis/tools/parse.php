<? 
include '../inc/localis_lib.php';

$conf = parseconf('../etc/localis.conf');

foreach ($conf as $k=>$v) {
	echo "$k = $v\n";
}
?>
