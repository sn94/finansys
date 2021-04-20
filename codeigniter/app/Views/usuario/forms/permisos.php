
  <fieldset>
      <legend>PERMISOS</legend>
      <div class="table-responsive">

        <table class="table">
          <thead>
            <tr>
              <th>NOMBRE PERMISO</th>
              <th> <input disabled type="checkbox" onchange="accionarCheckboxes(event)" id="supermarcador"></th>
            </tr>
          </thead>

          <tbody id="permisos">

            <?php foreach ($permisos as $it) :  ?>

              <tr>
                <td><?= $it->PERMISO ?> </td>
                <td><input disabled style="transform: scale(2);" type="checkbox" name="PERMISO[]" value="<?= $it->IDNRO ?>"></td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>

      </div>
    </fieldset>




 