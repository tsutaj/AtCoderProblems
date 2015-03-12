<?php
require_once 'simple_html_dom.php';
require_once 'sql.php';

$sql = new SQLConnect ();
$pull = $sql->pullContests ();

$array = array ();
foreach ( $pull as $element ) {
	$name = $element ["name"];
	if (preg_match ( '/(abc|arc)[0-9]*/i', $element ["name"] )) {
		array_push ( $array, $element );
	}
}

// 列nameでソートしたい
foreach ( $array as $key => $row ) {
	$n [$key] = $row ["name"];
}
array_multisort ( $n, SORT_ASC, $array );

for($i = 0; $i < count ( $array ); $i ++) {
	$problems = $sql->getProblems ( $array [$i] ["id"] );
	$array [$i] ["problems"] = array ();
	foreach ( $problems as $p ) {
		array_push ( $array [$i] ["problems"], $p );
	}
}
include 'html.inc';
function listupARC($array) {
	foreach ( $array as $contest ) {
		echo '<tr>';
		
		$contest_name = $contest ["name"];
		$contest_title = $contest ["title"];
		
		echo "<td><a href='http://$contest_name.contest.atcoder.jp/'>";
		echo "$contest_title";
		echo "</a></td>";
		
		foreach ( $contest ["problems"] as $contest_problem ) {
			$contest_problem_name = $contest_problem ["name"];
			$contest_problem_title = $contest_problem ["title"];
			
			echo "<td><a href='http://$contest_name.contest.atcoder.jp/tasks/$contest_problem_name'>";
			echo $contest_problem_title;
			echo "</a></td>";
		}
		
		echo '</tr>';
	}
}



