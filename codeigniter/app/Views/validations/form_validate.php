<script>
    var formValidator = {

        form: null,
        init: function(formObject) {
            this.form = formObject;



        },
        limpiarCampos: function() {

            let elements = this.form.elements;
            Array.prototype.forEach.call(elements, function(ar) {
                ar.value = "";
            });
        },
        esNumerico: function(objDom) {
            let clases = objDom.classList;

            let numerico = false;
            for (let g = 0; g < clases.length; g++) {
                if (clases[g] == "entero" || clases[g] == "decimal") {
                    numerico = true;
                    break;
                }
            }
            return numerico;
        },
        limpiarNumero: function(val) {
            let stringified = typeof val == "string" ? val : String(val);

            stringified = stringified == "" ? "0" : stringified;

            let valor_purifi = stringified.replaceAll(new RegExp(/\.*[A-Za-z]*/g), "").replaceAll(new RegExp(/,+/g), ".");
             
            return valor_purifi;

        },
        getData: function(type) {

            type = type == undefined ? 'application/x-www-form-urlencoded' : type;
            if (type == "application/x-www-form-urlencoded") {
                let list_params = [];
                let elements = this.form.elements;
                let contextoThis = this;
                Array.prototype.forEach.call(elements, function(ar) {

                    let valorPurificado = null;
                    if (contextoThis.esNumerico(ar)) {
                        valorPurificado = contextoThis.limpiarNumero(ar.value);
                    } else {
                        valorPurificado = ar.value;
                    }

                    list_params.push(ar.name + "=" + valorPurificado);
                });

                return list_params.join("&");

            }
            if (type == "application/json") {
                let object_params = {};
                let elements = this.form.elements;
                let contextoThis = this;
                Array.prototype.forEach.call(elements, function(ar) {

                    let valorPurificado = null;
                    if (contextoThis.esNumerico(ar)) {
                        valorPurificado = contextoThis.limpiarNumero(ar.value);
                    } else {
                        valorPurificado = ar.value;
                    }

                    object_params[ar.name] = valorPurificado;

                });
                return object_params;
            }


        }
    };
</script>