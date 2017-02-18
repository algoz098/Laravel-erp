<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-9">
    <div id="fileuploader">Escolher arquivo</div>
    <div id="extrabutton" class="btn btn-success">Enviar</div>
  </div>
</div>
<script>
$(document).ready(function(){
  var extraObj = $("#fileuploader").uploadFile({
    url:"{{url('attach/')}}/{{$modulo}}/{{$id}}/{{$contatos_id}}",
    fileName:"file",
    extraHTML:function()
    {
      var html = "<div class='form-group'><label class='control-label'>Nome</label><input type='text' name='name' id='name' class='form-control'></div>";
      html += '{{csrf_field() }}';
      return html;
    },
    autoSubmit:false,
    dragDropStr: "<span><b>Solte aqui</b></span>",
    cancelStr:"Cancelar",
    uploadStr:"Escolher",
    returnType:"json",
    afterUploadAll:function(obj)
    {
      $.get( window.modalurl, function( data ) {
       $( "#modal" ).html( data );
      });
    }
  });
  $("#extrabutton").click(function()
  {
   extraObj.startUpload();
  });
});
</script>
