<?php

$PORCENTAJE =  !isset($dato) ? "" :   $dato->PORCENTAJE;

?>
<div class="row">

  <div class="col-12 col-md-5"  style="display: grid;  grid-template-columns: 30% 70% ;">

    <label style="grid-column-start: 1;" >PORCENTAJE:</label>
    <input  style="grid-column-start: 2;" oninput="formatear_decimal(event)" name="PORCENTAJE" type="text" class="form-control" value="<?= $PORCENTAJE ?>">
  </div>

  <?php if (!isset($vista)) : ?>
    <div class="col-12 col-md-6">
      <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
  <?php endif; ?>
</div>


<script>
  function dar_formato_millares(val_float) {
    return new Intl.NumberFormat("de-DE").format(val_float);
  }




  function limpiar_numero_para_float(val) {
    return val.replaceAll(new RegExp(/[.]*/g), "").replaceAll(new RegExp(/[,]{1}/g), ".");
  }



  function formatear_decimal(ev) { //

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
      let solo_decimal = limpiar_numero_para_float(ev.target.value);
      let float__ = parseFloat(solo_decimal);
      let enpuntos = dar_formato_millares(float__);
      if (   !(isNaN(enpuntos) )  ) 
      $(ev.target).val(enpuntos);
      return;
    }

    //convertir a decimal
    //dejar solo la coma decimal pero como punto 
    let solo_decimal = limpiar_numero_para_float(ev.target.value);
    let noEsComaOpunto = ev.data.charCodeAt() != 44 && ev.data.charCodeAt() != 46;
    if (noEsComaOpunto) {
      let float__ = parseFloat(solo_decimal);

      //Formato de millares 
      let enpuntos = dar_formato_millares(float__);
      if (   !(isNaN(enpuntos) )  ) 
      $(ev.target).val(    enpuntos);
    }
  }


     function limpiar_campos(ev) {

         let elements = ev.target.elements;
         Array.prototype.forEach.call(elements, function(ar) {
             ar.value = "";
         });
     }

     async function guardar(ev) {
         ev.preventDefault();
         let req = await fetch(ev.target.action, {
             "method": "POST",
             headers: {
                 'Content-Type': 'application/x-www-form-urlencoded'
             },
             body: $(ev.target).serialize()
         });
         let resp = await req.json();
         if(  "auth_error" in resp )
        {
            alert(  resp.auth_error );
            window.location=  resp.redirect;
        }
        
         if ("ok" in resp) {
             limpiar_campos( ev );
             act_grilla();
         } else alert(resp.error);

     }
 </script>