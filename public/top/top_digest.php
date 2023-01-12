<?php

require_once dirname(__FILE__).'./../common/const.php';
require_once dirname(__FILE__).'./../class/sql.php';

class top_digest extends sql{

public static function getEngineerCount($proc_id){
   //自分のインスタンスを作成
   $jibun = new top_digest();

  //DB接続
  //DBへの接続PDOインスタンスを生成する
  $dbh= $jibun->createPDOInstance();

  //Sql文を作成
  $sql='SELECT count(*) count from enjineer_basic_info ';
  $sql.= $jibun->getWhere_engineer_count($proc_id);

  //ユーザ情報の検索SQLを実行する
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  //実行結果からレコードを取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  //カウント結果を取得
  return $rec["count"].'件';
}

/**
エンジニア情報のタイプに応じてWhere句を返す
*/
function getWhere_engineer_count($proc_id){
 $where_phrase = '';

   if($proc_id == ConstClass::CONST_PROC_ID_ENGINEER_IN_PROGRESS){
     $where_phrase = 'where status_flag=\'0\' and del_flag=\'0\'';  //作成中のエンジニア情報

   }else if ($proc_id == ConstClass::CONST_PROC_ID_ENGINEER_YET_OPENED){
     $where_phrase = 'where status_flag=\'1\' and del_flag=\'0\''; //作成済み、公開前のエンジニア情報

   }else if($proc_id == ConstClass::CONST_PROC_ID_ENGINEER_OPENED){
     $where_phrase = 'where status_flag=\'2\' and del_flag=\'0\''; //作成済み、公開済みのエンジニア情報
   }
  return $where_phrase;
 }
}
?>
