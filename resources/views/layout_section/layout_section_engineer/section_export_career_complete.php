@extends('layout_base.base_4L')

@section('title', 'エンジニア情報出力')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報出力
@endslot
@endcomponent

@section('content1')

<form>
    @csrf

 <div class="box3">
    <table>
      <tr>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','open_top')">TOP戻る</a>
          </div>
       </td>
     </tr>
   </table>
  </div>
 </form>

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection
