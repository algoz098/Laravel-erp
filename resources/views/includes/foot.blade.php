
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
  var scroll = jQuery(document).scroll(function() {
      if (jQuery(this).scrollTop() > 175) {
          jQuery('#secondNavbar').css({
             'position': 'fixed',
             'top': '50px',
             'width': '100%'
          });
      }
      else {
          jQuery('.menu-secondary-wrap').css('position','static');
      }
  });
  $(document).ready(function(){
    $('#mostrarAjuda').on('click', function(){
        $(".ajuda-popover").popover('toggle');
    });
    $(".ajuda-popover").on('hidden.bs.popover', function(){
       //$(".ajuda-popover").popover("destroy");
   });
  });

  $(function() {
    $( ".datepicker" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy",
                        yearRange: "-100:+0"
                      });
  });

  $("#cep").mask("99999-999");
  $("#valor").maskMoney({thousands:'', decimal:'.', allowZero:true});
  $(".real-mask").maskMoney({thousands:'', decimal:'.', allowZero:true});
  $(document).ready(function() {
    $(".integer-mask").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>
