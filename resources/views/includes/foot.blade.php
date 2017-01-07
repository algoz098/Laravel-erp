
<script src="{{ asset('js/pushy.min.js') }}"></script>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script language="javascript">
  tinymce.init({
    selector: 'textarea',
    height: 200,
    menubar: false,
    plugins: [
      'advlist autolink lists link charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime table contextmenu paste code'
    ],
    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

  });


  $(document).ready(function(){
    $('#mostrarAjuda').on('click', function(){
        $(".ajuda-popover").popover('toggle');
    });
    $(".ajuda-popover").on('hidden.bs.popover', function(){
       //$(".ajuda-popover").popover("destroy");
   });
  });

  $("#cep").mask("99999-999");
  $("#valor").maskMoney({thousands:'', decimal:'.', allowZero:true});
</script>
