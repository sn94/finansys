<?php

$LETRA =  !isset($dato) ? "" :   $dato->LETRA;

$ULT_NUMERO =  !isset($dato) ? "" :   $dato->ULT_NUMERO;

?>
<div class="row">

  <div class="col-12 col-md-4" style="display: grid;  grid-template-columns: 30% 70% ;">

    <label style="grid-column-start: 1;">LETRA:</label>
    <input oninput="event.target.value= event.target.value.toUpperCase(); " maxlength="4" style="grid-column-start: 2;text-transform: uppercase;" name="LETRA" type="text" class="form-control" value="<?= $LETRA ?>">
  </div>

  <div class="col-12 col-md-4" style="display: grid;  grid-template-columns: 30% 70% ;">

    <label style="grid-column-start: 1;">ÚLT. NÚMERO:</label>
    <input maxlength="5" oninput="numero_natural(event)" style="grid-column-start: 2;" name="ULT_NUMERO" type="text" class="form-control" value="<?= $ULT_NUMERO ?>">
  </div>

  <?php if (!isset($vista)) : ?>
    <div class="col-12 col-md-4">
      <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
  <?php endif; ?>
</div>


<script>
  function dar_formato_millares(val_float) {
    return new Intl.NumberFormat("de-DE").format(val_float);
  }




  function numero_natural(ev) {
    if (ev.data != undefined) {
      if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
        ev.target.value =
          ev.target.value.substr(0, ev.target.selectionStart - 1) +
          ev.target.value.substr(ev.target.selectionStart);
      }
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

      limpiar_campos(ev);
      act_grilla();
    } else alert(resp.error);

  }
</script>