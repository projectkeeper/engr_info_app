function button_press(button_id, proc_id, base_info_id, action_name) {
//function button_press(action_name) {
alert('hello3' + action_name);

//「検索ボタンID」のエレメントの設定
if(button_id){
 var ele = document.createElement('input');
 ele.setAttribute('type', 'hidden');
 ele.setAttribute('name',  'button_id');
 ele.setAttribute('value', button_id);
 document.forms[0].appendChild(ele);　// 要素を追加
}

// 「次の処理ID」のエレメントの設定
if(proc_id){
  var ele2 = document.createElement('input');
  ele2.setAttribute('type', 'hidden');
  ele2.setAttribute('name', 'proc_id');
  ele2.setAttribute('value', proc_id);
  document.forms[0].appendChild(ele2);　// 要素を追加
}

// 「engineerの基本情報ID」のエレメントの設定
if(base_info_id){
  var ele3 = document.createElement('input');
  ele3.setAttribute('type', 'hidden');
  ele3.setAttribute('name', 'base_info_id');
  ele3.setAttribute('value', base_info_id);
  document.forms[0].appendChild(ele3);// 要素を追加
}

 //アクション名の設定
 document.forms[0].action = action_name;
 document.forms[0].method="post";
 document.forms[0].submit();
}

//指定idのタグに、指定したvalueを設定する。
function setValtoId(id, value) {

  alert('id: ' + id);
  //alert('value: ' + id);
  document.getElementById(id).value = value;
}
