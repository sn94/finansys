<script>
  var formatoNumerico = {


    darFormatoEnMillares: function(val_float) {
      return new Intl.NumberFormat("de-DE", {
        minimumFractionDigits: 4,
        maximumFractionDigits: 4
      }).format(val_float);
    },
    limpiarNumeroParaFloat: function(val) {
      return val.replaceAll(new RegExp(/[.]*/g), "").replaceAll(new RegExp(/[,]{1}/g), ".");
    },
    formatearEntero: function(ev) {
      if (ev.data != undefined) {
        if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
          ev.target.value =
            ev.target.value.substr(0, ev.target.selectionStart - 1) +
            ev.target.value.substr(ev.target.selectionStart);
        }
      }
      //Formato de millares
      let val_Act = ev.target.value;
      val_Act = val_Act.replaceAll(new RegExp(/[\.]*[,]*/g), "");
      let enpuntos = new Intl.NumberFormat("de-DE").format(val_Act);
      $(ev.target).val(enpuntos);
    },
    formatearDecimal: function(ev) { //

      let contextoThis = {
        limpiarNumeroParaFloat: function(val) {
          return val.replaceAll(new RegExp(/[.]*/g), "").replaceAll(new RegExp(/[,]{1}/g), ".");
        },
        darFormatoEnMillares: function(val_float) {
          return new Intl.NumberFormat("de-DE", {
            minimumFractionDigits: 4,
            maximumFractionDigits: 4
          }).format(val_float);
        }
      };
      if (ev.data != undefined) {
        if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
          let noEsComa = ev.data.charCodeAt() != 44;
          let yaHayComa = ev.data.charCodeAt() == 44 && /(,){1}/.test(ev.target.value.substr(0, ev.target.value.length - 2));
          let comaPrimerLugar = ev.data.charCodeAt() == 44 && ev.target.value.length == 1;
          let comaDespuesDePunto = ev.data.charCodeAt() == 44 && /\.{1},{1}/.test(ev.target.value);
          if (noEsComa || (yaHayComa || comaPrimerLugar || comaDespuesDePunto)) {
            ev.target.value = ev.target.value.substr(0, ev.target.selectionStart - 1) + ev.target.value.substr(ev.target.selectionStart);
            return;
          } else return;
        }
      }

      if (ev.data == undefined) {
        let solo_decimal = contextoThis.limpiarNumeroParaFloat(ev.target.value);
        let float__ = parseFloat(solo_decimal);
        let enpuntos = contextoThis.darFormatoEnMillares(float__);
        if (!(isNaN(enpuntos)))
          $(ev.target).val(enpuntos);
        return;
      }

      //convertir a decimal
      //dejar solo la coma decimal pero como punto 
      let solo_decimal = contextoThis.limpiarNumeroParaFloat(ev.target.value);
      let noEsComaOpunto = ev.data.charCodeAt() != 44 && ev.data.charCodeAt() != 46;
      if (noEsComaOpunto) {
        let float__ = parseFloat(solo_decimal);

        //Formato de millares 
        let enpuntos = contextoThis.darFormatoEnMillares(float__);
        if (!(isNaN(enpuntos)))
          $(ev.target).val(enpuntos);
      }
    },
    limpiarNumeros: function() {
      let nro_campos_a_limp = $(".decimal,.entero").length;

      for (let ind = 0; ind < nro_campos_a_limp; ind++) {
        let valor = $(".decimal,.entero")[ind].value;
        let valor_purifi = valor.replaceAll(new RegExp(/[.]*/g), "").replaceAll(new RegExp(/,+/g), ".");
        $(".decimal,.entero")[ind].value = valor_purifi;
      }
      //return val.replaceAll(new RegExp(/[.]*/g), "");
    },

    restaurarMillares: function() {
      let nro_campos_a_limp = $(".decimal,.entero").length;

      for (let ind = 0; ind < nro_campos_a_limp; ind++) {
        let valor = $(".decimal,.entero")[ind].value;
        //Es un numero decimal?
        //  if( /\./.test(  valor ) )  valor=  valor.replaceAll(".", ",");

        let valor_forma = this.darFormatoEnMillares(valor);
        $(".decimal,.entero")[ind].value = valor_forma;
      }
      //return val.replaceAll(new RegExp(/[.]*/g), "");
    }



  };
</script>