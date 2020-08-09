import Axios from "axios";
//arreglo para la validacion de formularios de el lado de la vista
export default {
    data() {
        return {
            rules_form: {
                requerido: v => !!v || "Este campo es requerido",
                //!/^([0-9])*$/
                numeros: v => /^([0-9])*$/.test(v) || "Este campo debe ser númerico",
                letrasnumeros: v =>
                    /^([0-9A-Za-z])*$/.test(v) ||
                    "Este campo no permite caracteres especiales, acentos o espacios",
                alfanumerico: v =>
                    /^([0-9 A-Za-zñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ])*$/.test(v) ||
                    "Este campo no permite caracteres especiales",
                sololetras: v =>
                    /^([ A-Za-zñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ])*$/.test(
                        v
                    ) || "Este campo no permite números ni caracteres especiales",
                maximo50caracteres: v =>
                    (v && v.length <= 50) ||
                    "Este campo no debe superar los 50 caracteres",
                maximo255caracteres: v =>
                    (v && v.length <= 255) ||
                    "Este campo no debe superar los 255 caracteres",
                maximo500caracteres: v =>
                    (v && v.length <= 500) ||
                    "Este campo no debe superar los 500 caracteres",
                maximo10caracterestel: v =>
                    (v && v.length <= 10) ||
                    "Este campo no debe superar los 10 caracteres",

                email: v => /.+@.+\..+/.test(v) || "Correo electrónico no válido",

                numerospass: v => /^(?=.*\d)/.test(v) || 'Debe contener al menos un valor númerico',
                letraspass: v => /^(?=.*[a-z])(?=.*[A-Z])/.test(v) || 'Debe contener letras mayusculas y minusculas',
                minpass: v => /^.{6,15}$/.test(v) || 'Debe tener entre 6 y 15 caracteres'
            },
        }
    },
    methods: {
        //funcion que permite que el campo sea solamente numerico
        onlyNumber ($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
        },
       

    }
};
