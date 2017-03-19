<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby=""></div>
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby=""></div>
<script src="{{ asset('js/pushy.min.js') }}"></script>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script language="javascript">

  var height = $(window).height()-200;
  function retornarEsta(id, nome) {
    if (($("#modal2").data('bs.modal') || {}).isShown) {
      window.contatos_id2 = id;
      window.contatos_nome2 = nome;
      console.log(window.contatos_id2, window.contatos_nome2);
      $('#modal2').modal('toggle');
    } else{
      if (($("#modal").data('bs.modal') || {}).isShown) {
        window.contatos_id = id;
        window.contatos_nome = nome;
        $('#modal').modal('toggle');
        console.log(window.contatos_id, window.contatos_nome);
      }
    }
  };


  $(document).ready( function (){
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
  });

  var scroll = jQuery(document).scroll(function() {
      if (jQuery(this).scrollTop() > 105) {
        jQuery('#secondNavbar').css({
           'position': 'fixed',
           'top': '50px',
           'width': '100%'
        });
        jQuery('#thirdNavbar').css({
           'position': 'fixed',
           'top': '85px',
           'width': '100%'
        });
      }
      else {
          jQuery('.menu-secondary-wrap').css('position','static');
      }
  });

  $(function() {
    $( ".datepicker" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy",
                        yearRange: "-100:+0"
                      });
  });
  $(function() {
    $( ".datepicker_mes_ano" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "mm-yy",
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
  $(document).keyup(function(event){
      if(event.keyCode == 13){
          $("#"+focandoEnter).click();
      }
  });
  function openModal(url){
    if (($("#modal").data('bs.modal') || {}).isShown) {
      $("#modal2").modal('show');
      $( "#moda2").html();
      $.ajax({
        type: 'GET',
        url: url,
        success: function( data ) {
          $( "#modal2" ).html( data );
          $('.colocar-rolagem').css({'max-height': height});

        },
        error: function(xhr, status, error) {
          $("#modal2").modal('hide');
          $('.colocar-rolagem').css({'max-height': height});
        }
      });
    } else {
      $("#modal").modal('show');
      $( "#modal").html();
      $.ajax({
        type: 'GET',
        url: url,
        success: function( data ) {
          $( "#modal").html( data );
        },
        error: function(xhr, status, error) {
          $("#modal").modal('hide');
        }
      });
    }
  };
  function efetuarBusca(url, target){
    $("#"+target).addClass("carregando");
    $('#botaoSalvar'+target).hide();
    var data = {
      'busca'              : $('input[name=busca]').val(),
      '_token'            : $('input[name=_token]').val(),
      'apenas_filial'      : $('#apenas_filial').val(),
      'data_de'       : $('#data_de').val(),
      'data_ate'       : $('#data_ate').val(),
      'assunto'       : $('#assunto').val(),
      'subgrupoBusca'       : $('#grupoHidden').val(),
      'aplicacaoBusca'       : $('#aplicacaoBusca').val(),
      'fabricanteBusca'       : $('#fabricanteBusca').val(),
      'codigoBusca'       : $('#codigoBusca').val()
    };
    $.ajax({
      type: 'post',
      url: url,
      data: data,
      success: function( data ) {
        $( "#listaHolder"+target ).html( data );
        $("#listaHolder"+target).removeClass("carregando");
      },
    });
  }
  /*$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
    if (!jQuery.isEmptyObject(jqxhr.responseText)){
      var a = jQuery.parseJSON( jqxhr.responseText );
      for (var contador = 0, len = a.length; contador < len; contador++) {
        var title = "@lang('messages.erro')";
        $.toaster({ message : a[contador], title : title, priority : 'danger' , settings : {'timeout' : 3000,}});
      }
    }
  });*/
  $('#modal').on("hidden.bs.modal", function (e) {
    if (typeof activeTarget != 'undefined'){
      $('#'+activeTarget+'Hidden').val(window.contatos_id);
      $('#'+activeTarget).val(window.contatos_nome);
    }
  });
  $('#modal2').on("hidden.bs.modal", function (e) {
    if (typeof activeTarget != 'undefined'){
      $('#'+activeTarget+'Hidden').val(window.contatos_id2);
      $('#'+activeTarget).val(window.contatos_nome2);
    }
  });



  !function ($) {

    "use strict"; // jshint ;_;


   /* TOOLTIP PUBLIC CLASS DEFINITION
    * =============================== */

    var Tooltip = function (element, options) {
      this.init('tooltip', element, options)
    }

    Tooltip.prototype = {

      constructor: Tooltip

    , init: function (type, element, options) {
        var eventIn
          , eventOut

        this.type = type
        this.$element = $(element)
        this.options = this.getOptions(options)
        this.enabled = true

        if (this.options.trigger == 'click') {
          this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
        } else if (this.options.trigger != 'manual') {
          eventIn = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
          eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
          this.$element.on(eventIn + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
          this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
        }

        this.options.selector ?
          (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
          this.fixTitle()
      }

    , getOptions: function (options) {
        options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

        if (options.delay && typeof options.delay == 'number') {
          options.delay = {
            show: options.delay
          , hide: options.delay
          }
        }

        return options
      }

    , enter: function (e) {
        var self = $(e.currentTarget)[this.type](this._options).data(this.type)

        if (!self.options.delay || !self.options.delay.show) return self.show()

        clearTimeout(this.timeout)
        self.hoverState = 'in'
        this.timeout = setTimeout(function() {
          if (self.hoverState == 'in') self.show()
        }, self.options.delay.show)
      }

    , leave: function (e) {
        var self = $(e.currentTarget)[this.type](this._options).data(this.type)

        if (this.timeout) clearTimeout(this.timeout)
        if (!self.options.delay || !self.options.delay.hide) return self.hide()

        self.hoverState = 'out'
        this.timeout = setTimeout(function() {
          if (self.hoverState == 'out') self.hide()
        }, self.options.delay.hide)
      }

    , show: function () {
        var $tip
          , inside
          , pos
          , actualWidth
          , actualHeight
          , placement
          , tp

        if (this.hasContent() && this.enabled) {
          $tip = this.tip()
          this.setContent()

          if (this.options.animation) {
            $tip.addClass('fade')
          }

          placement = typeof this.options.placement == 'function' ?
            this.options.placement.call(this, $tip[0], this.$element[0]) :
            this.options.placement

          inside = /in/.test(placement)

          $tip
            .detach()
            .css({ top: 0, left: 0, display: 'block' })
            .insertAfter(this.$element)

          pos = this.getPosition(inside)

          actualWidth = $tip[0].offsetWidth
          actualHeight = $tip[0].offsetHeight

          switch (inside ? placement.split(' ')[1] : placement) {
            case 'bottom':
              tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
              break
            case 'top':
              tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
              break
            case 'left':
              tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
              break
            case 'right':
              tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
              break
          }

          $tip
            .offset(tp)
            .addClass(placement)
            .addClass('in')
        }
      }

    , setContent: function () {
        var $tip = this.tip()
          , title = this.getTitle()

        $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
        $tip.removeClass('fade in top bottom left right')
      }

    , hide: function () {
        var that = this
          , $tip = this.tip()

        $tip.removeClass('in')

        function removeWithAnimation() {
          var timeout = setTimeout(function () {
            $tip.off($.support.transition.end).detach()
          }, 500)

          $tip.one($.support.transition.end, function () {
            clearTimeout(timeout)
            $tip.detach()
          })
        }

        $.support.transition && this.$tip.hasClass('fade') ?
          removeWithAnimation() :
          $tip.detach()

        return this
      }

    , fixTitle: function () {
        var $e = this.$element
        if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
          $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
        }
      }

    , hasContent: function () {
        return this.getTitle()
      }

    , getPosition: function (inside) {
        return $.extend({}, (inside ? {top: 0, left: 0} : this.$element.offset()), {
          width: this.$element[0].offsetWidth
        , height: this.$element[0].offsetHeight
        })
      }

    , getTitle: function () {
        var title
          , $e = this.$element
          , o = this.options

        title = $e.attr('data-original-title')
          || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

        return title
      }

    , tip: function () {
        return this.$tip = this.$tip || $(this.options.template)
      }

    , validate: function () {
        if (!this.$element[0].parentNode) {
          this.hide()
          this.$element = null
          this.options = null
        }
      }

    , enable: function () {
        this.enabled = true
      }

    , disable: function () {
        this.enabled = false
      }

    , toggleEnabled: function () {
        this.enabled = !this.enabled
      }

    , toggle: function (e) {
        var self = $(e.currentTarget)[this.type](this._options).data(this.type)
        self[self.tip().hasClass('in') ? 'hide' : 'show']()
      }

    , destroy: function () {
        this.hide().$element.off('.' + this.type).removeData(this.type)
      }

    }


   /* TOOLTIP PLUGIN DEFINITION
    * ========================= */

    var old = $.fn.tooltip

    $.fn.tooltip = function ( option ) {
      return this.each(function () {
        var $this = $(this)
          , data = $this.data('tooltip')
          , options = typeof option == 'object' && option
        if (!data) $this.data('tooltip', (data = new Tooltip(this, options)))
        if (typeof option == 'string') data[option]()
      })
    }

    $.fn.tooltip.Constructor = Tooltip

    $.fn.tooltip.defaults = {
      animation: true
    , placement: 'top'
    , selector: false
    , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
    , trigger: 'hover'
    , title: ''
    , delay: 0
    , html: false
    }


   /* TOOLTIP NO CONFLICT
    * =================== */

    $.fn.tooltip.noConflict = function () {
      $.fn.tooltip = old
      return this
    }

  }(window.jQuery);
  $(function () {
    $('*[data-toggle="tooltip"]').tooltip();
  });
</script>
