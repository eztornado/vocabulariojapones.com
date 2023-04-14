@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <br/><br/>
    <h1>Aprender Japonés     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Cambiar voz
        </button></h1>

@stop

@section('content')
    </br></br></br>
    <span style="font-size: 120px"><b>{{$datos[$seleccionado]->original}}</b></span>
    </br>
    <span style="font-size: 60px;color: red">{{$datos[$seleccionado]->hiragana}}</span>
    </br>
    <span style="font-size: 60px">{{$datos[$seleccionado]->traducido}}</span>

    <br/><br/>
    <div class="full-width-div">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-default" onclick="leerPalabra()">Escuchar</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-default" onclick="nuevaPalabra()">Nueva Palabra</button>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar de voz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-group">
                                <label>Escoge una voz:</label>
                                <select id="select_idioma"  name="select_idioma" class="custom-select">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Probar()">Probar seleccionado</button>
                    <button type="button" class="btn btn-primary" onclick="CambiarVoz()">Aplicar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

        var palabra = '{{$datos[$seleccionado]->original}}';

        window.onload = function() {
            searchJPVoice();
        };

        function searchJPVoice(){

                setTimeout(() => {
                    let voices = window.speechSynthesis.getVoices();
                    var x = document.getElementById("select_idioma");
                    console.log(voices);
                    let resultado = 0;
                    let i = 0;
                    voices.forEach(v => {
                        if(v.lang == "ja-JP") {
                            var option = document.createElement("option");
                            option.text = i + " | " + v.name + " | " + v.lang;
                            x.add(option, i);
                        }
                        if ( v.lang == "ja-JP") {
                            resultado = i;
                        }
                        i = i + 1;
                    });

                    console.log(resultado);
                    if(resultado != 0)
                        if(window.localStorage.getItem('voice_id') == null) {
                            window.localStorage.setItem('voice_id', resultado);
                        }
                    if(resultado == 0){
                        searchJPVoice();
                    }
                }, 50);
        }

        function nuevaPalabra(){
            location.reload();
        }

        function leerPalabra(){

            if ('speechSynthesis' in window) {
                var x = document.getElementById("select_idioma");
                console.log('reproduciendo con voz : ' + parseInt(window.localStorage.getItem('voice_id')));
                // Speech Synthesis supported 🎉
                var msg = new SpeechSynthesisUtterance();
                var voices = window.speechSynthesis.getVoices();
                msg.voice = voices[parseInt(window.localStorage.getItem('voice_id'))];
                msg.volume = 1; // From 0 to 1
                msg.rate = 0.8; // From 0.1 to 10
                msg.pitch = 0; // From 0 to 2
                msg.text = palabra;
                //msg.lang = 'jp';
                window.speechSynthesis.speak(msg);

            }else{
                // Speech Synthesis Not Supported 😣
                alert("Sorry, your browser doesn't support text to speech!");
            }
        }

        function Probar(){
            if ('speechSynthesis' in window)
            {
                var x = document.getElementById("select_idioma");
                let valor = x.value;
                let valores = valor.split('|');
                console.log('reproduciendo con voz : ' + parseInt(valores[0]));
                // Speech Synthesis supported 🎉
                var msg = new SpeechSynthesisUtterance();
                var voices = window.speechSynthesis.getVoices();
                msg.voice = voices[parseInt(valores[0])];
                msg.volume = 1; // From 0 to 1
                msg.rate = 0.8; // From 0.1 to 10
                msg.pitch = 0; // From 0 to 2
                msg.text = 'おねえちゃんやめってください！';
                //msg.lang = 'jp';
                window.speechSynthesis.speak(msg);

            }else{
                // Speech Synthesis Not Supported 😣
                alert("Sorry, your browser doesn't support text to speech!");
            }
        }

        function CambiarVoz(){
            var x = document.getElementById("select_idioma");
            let valor = x.value;
            let valores = valor.split('|');
            window.localStorage.setItem('voice_id', parseInt(valores[0]));
            $('#exampleModal').modal('hide');
        }

    </script>
@stop
