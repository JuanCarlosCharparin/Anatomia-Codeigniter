<style>
 /* Estilos para los elementos seleccionados */
.select2-selection__choice {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
    border-radius: 3px;
    padding: 2px 5px;
    margin-right: 5px;
}

/* Estilo para el icono de eliminar */
.select2-selection__choice__remove {
    margin-left: 5px;
    cursor: pointer;
}

/* Estilos para el menú desplegable */
.select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    z-index: 10000; /* Asegura que el menú desplegable aparezca por encima de otros elementos */
}

/* Ajuste para la altura del menú desplegable */
.select2-container--bootstrap .select2-dropdown {
    margin-top: 0;
    margin-bottom: 20px; /* Ajusta según sea necesario */
    position: absolute;
    top: 100%;
    left: 0;
    display: block;
    width: 100%;
    background-color: white;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    z-index: 10000;
}

</style>

<form id="editEstudioForm">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="paciente" class="form-label">Paciente:</label>
            <?= $estudio['paciente']; ?>
        </div>
        <div class="col-md-6">
            <label for="n_servicio" class="form-label">Número de Servicio:</label>
            <input type="text" class="form-control" id="n_servicio" name="n_servicio" value="<?= $estudio['n_servicio'] ?>" readonly>
        </div>
    </div>
    <hr>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="edad" class="form-label">Edad:</label>
            <?= $estudio['edad'] ?> años
        </div>
        <div class="col-md-6">
            <label for="prof_sol" class="form-label">Informado por:</label>
            <?= $estudio['profesional']; ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="dni" class="form-label">DNI:</label>
            <?= $estudio['documento'] ?>
        </div>
        <div class="col-md-6">
            <label for="fecha_nacimiento" class="form-label">F. Nac:</label>
            <?= $estudio['fecha_nacimiento'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="sexo" class="form-label">Sexo:</label>
            <?= $estudio['sexo'] ?>
        </div>
        <div class="col-md-6">
            <label for="obra_social" class="form-label">Obra Social:</label>
            <?= $estudio['obra_social'] ?>
        </div>
    </div>
    <p></p>
    <hr>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="servicio" class="form-label">Servicio:</label>
            <?= $estudio['servicio']; ?>
        </div>
        <div class="col-md-6">
            <label for="medico" class="form-label">Profesional solicitante:</label>
            <?= $estudio['medico']; ?>
        </div>
        <p></p>
        <hr>
    </div>

    <div class="row mb-3">
            <div class="col-md-6">
            <label for="tipo_estudio" class="form-label">Tipo de estudio:</label>
            <select id="tipo_estudio_id" name="tipo_estudio_id" class="form-control">
                <option value="1" <?= $estudio['tipo_estudio_id'] == 1 ? 'selected' : '' ?>>Biopsia</option>
                <option value="2" <?= $estudio['tipo_estudio_id'] == 2 ? 'selected' : '' ?>>Citologia</option>
                <option value="3" <?= $estudio['tipo_estudio_id'] == 3 ? 'selected' : '' ?>>Pap</option>
                <option value="4" <?= $estudio['tipo_estudio_id'] == 4 ? 'selected' : '' ?>>Intraoperatorio</option>
            </select>
        </div>
        
    </div>
    <p></p>
    <hr>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="diagnostico" class="form-label">Diagnóstico Presuntivo:</label>
            <input type="text" class="form-control" id="diagnostico" name="diagnostico" value="<?= $estudio['diagnostico'] ?>">
        </div>
        <p></p>
        <div class="col-md-6">
            <label for="fecha_carga" class="form-label">Fecha de carga:</label>
            <input type="text" class="form-control" id="fecha_carga" name="fecha_carga" value="<?= $estudio['fecha_carga'] ?>">
            <p></p>
        </div>

        
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="estado" class="form-label">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= $estudio['estado'] ?>">
        </div>

        <div class="col-md-6">
            <p></p>
            <label for="material" class="form-label">Material:</label>
            <?= $estudio['material']; ?>
        </div>
    </div>
    <p></p>
    <hr>

    <!-- Mostrar formulario específico para Pap -->
    <?php if ($estudio['tipo_estudio_id'] == 3): ?>
        <div id="pap_estudio" action="<?= site_url('biopsia/adjuntar_detalle') ?>" method="post" class="row mb-3">
            <div class="col-md-6">
                <label for="estado_especimen">Estado Especimen:</label>
                <select class="select2" id="estado_especimen" name="estado_especimen[]" multiple="multiple" style="width: 100%;">
                    <option value="Satisfactorio">Satisfactorio</option>
                    <option value="Menor por defecto de fijacion">Menor de lo optimo por defecto de fijacion o desecacion</option>
                    <option value="Menor por hemorrragia">Menor de lo optimo por hemorrragia</option>
                    <option value="Menor por citolisis">Menor de lo optimo por citolisis</option>
                    <option value="Menor por inflamacion">Menor de lo optimo por inflamacion</option>
                    <option value="Insactifactorio por escasa celularidad">Insactifactorio por escasa celularidad</option>
                    <option value="Insactifactorio por defecto de fijacion">Insactifactorio por defecto de fijacion o desecacion</option>
                    <option value="Insactifactorio por inflamacion">Insactifactorio por inflamacion</option>
                    <option value="Insactifactorio por hemorrragia">Insactifactorio por hemorrragia</option>
                    <option value="Insactifactorio por citolisis">Insactifactorio por citolisis</option>
                    <option value="Insactifactorio por componente_endocervical">Insactifactorio por sin componente endocervical</option>
                    <option value="Insactifactorio por otros">Insactifactorio por otros</option>
                    <option value="Sin componente endocervical">Sin componente endocervical</option>
                </select>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celulas_pavimentosas">Celulas pavimentosas presentes:</label>
                <select class="select2" id="celulas_pavimentosas" name="celulas_pavimentosas[]" multiple="multiple" style="width: 100%;">
                    <option value="Superficiales">Superficiales</option>
                    <option value="Intermedias">Intermedias</option>
                    <option value="Parabasales">Parabasales</option>
                    <option value="Basales">Basales</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celulas_cilindricas">Celulas Cilindricas:</label>
                <select class="select2" id="celulas_cilindricas" name="celulas_cilindricas[]" multiple="multiple" style="width: 100%;">
                    <option value="Endocervicales conservadas">Endocervicales conservadas</option>
                    <option value="Endocervicales reactivas">Endocervicales reactivas</option>
                    <option value="Endocervicales no observan">Endocervicales no se observan</option>
                    <option value="Endocervicales con anomalias nucleares">Endocervicales con anomalias nucleares</option>
                    <option value="Endometriales presentes">Endometriales presentes</option>
                    <option value="Endometriales con anomalias nucleares">Endometriales con anomalias nucleares</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="valor_hormonal">Valor Hormonal:</label>
                <select class="form-control" name="valor_hormonal" id="valor_hormonal">
                    <option value="Trofico">Trofico</option>
                    <option value="Atrofico">Atrofico</option>
                    <option value="Hipotrofico">Hipotrofico</option>
                    <option value="Trofismo disociado">Trofismo Disociado o Irregular</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="fecha_lectura">Fecha Lectura:</label>
                <input type="date" class="form-control" id="fecha_lectura" name="fecha_lectura">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="valor_hormonal_HC">Valor Hormonal HC:</label>
                <select class="form-control" name="valor_hormonal_HC" id="valor_hormonal_HC">
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_reactivos">Cambios Reactivos:</label>
                <select class="select2" id="cambios_reactivos" name="cambios_reactivos[]" multiple="multiple" style="width: 100%;">
                    <option value="Asociados inflamacion_leve">Asociados a inflamacion leve</option>
                    <option value="Asociados inflamacion_moderada">Asociados a inflamacion moderada</option>
                    <option value="Asociados inflamacion_severa">Asociados a inflamacion severa</option>
                    <option value="Trastornos madurativos">Trastornos madurativos</option>
                    <option value="Efecto radioterapia">Efecto de radioterapia</option>
                    <option value="DIU">DIU</option>
                    <option value="Terapias hormonales">Terapias hormonales</option>
                    <option value="Otros">Otros</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_asoc_celula_pavimentosa">Cambios Asociados a Célula Pavimentosa:</label>
                <select class="select2" id="cambios_asoc_celula_pavimentosa" name="cambios_asoc_celula_pavimentosa[]" multiple="multiple" style="width: 100%;">
                    <option value="Escamas anucleadas">Escamas anucleadas</option>
                    <option value="Paraqueratosis">Paraqueratosis</option>
                    <option value="Binucleacion">Binucleacion</option>
                    <option value="Megalocariosis">Megalocariosis</option>
                    <option value="Hipercromasia">Hipercromasia</option>
                    <option value="Coilocitos">Coilocitos</option>
                    <option value="Anisocariosis">Anisocariosis</option>
                    <option value="Anfofilia">Anfofilia</option>
                    <option value="Anfofilia">Aros perinucleares</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_celula_glandulares">Anomalías en Células Glandulares:</label>
                <input type="text" class="form-control" id="cambios_celula_glandulares" name="cambios_celula_glandulares">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celula_metaplastica">Célula Metaplástica:</label>
                <select class="select2" id="celula_metaplastica" name="celula_metaplastica[]" multiple="multiple" style="width: 100%;">
                    <option value="Presentes">Presentes</option>
                    <option value="Semi maduras">Semi maduras</option>
                    <option value="Inmaduras">Inmaduras</option>
                    <option value="Megalocariosis_aspecto_reactivo">Con megalocariosis de aspecto reactivo</option>
                    <option value="Megalocariosis">Con megalocariosis</option>
                    <option value="Anisocariosis">Con anisocariosis</option>
                    <option value="Hipercromasia">Hipercromasia</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="otras_neo_malignas">Otras Neoplasias Malignas:</label>
                <input type="text" class="form-control" id="otras_neo_malignas" name="otras_neo_malignas">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="toma">Toma:</label>
                <select class="select2" id="toma" name="toma[]" multiple="multiple" style="width: 100%;">
                    <option value="Exo">Exo</option>
                    <option value="Endo">Endo</option>
                    <option value="Cupula">Cupula</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="recomendaciones">Recomendaciones:</label>
                <select class="select2" id="recomendaciones" name="recomendaciones[]" multiple="multiple" style="width: 100%;">
                    <option value="Tratar repetir">Tratar y repetir</option>
                    <option value="Estudio canal">Estudio del canal</option>
                    <option value="Reevaluacion_colposcopica">Reevaluacion colposcopica</option>
                    <option value="Biopsiar">Biopsiar</option>
                    <option value="Control Anual">Control Anual</option>
                    <option value="Control Semestral">Control Semestral</option>
                </select>

                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="microorganismos">Microorganismos:</label>
                <select class="select2" id="microorganismos" name="microorganismos[]" multiple="multiple" style="width: 100%;">
                    <option value="Hifas micoticas">Hifas micóticas</option>
                    <option value="Gardnerella">Gardnerella</option>
                    <option value="Actinomyces">Actinomyces</option>
                    <option value="Chlamydias">Chlamydias</option>
                    <option value="Cocobacilar">Cocobacilar</option>
                    <option value="Bacilar">Bacilar</option>
                    <option value="Trichomonas">Trichomonas</option>
                    <option value="Citomegalovirus">Citomegalovirus</option>
                    <option value="Herpes virus">Herpes Virus</option>
                    <option value="Cambios HPV">Cambios por HPV</option>
                    <option value="Cocos">Cocos</option>
                    <option value="Bacilos Doderlein">Bacilos de Doderlein</option>
                    <option value="Otros">Otros</option>
                </select>
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="resultado">Resultado:</label>
                <select class="select2" id="resultado" name="resultado[]" multiple="multiple" style="width: 100%;" placeholder="resultado">
                    <option value="Insactifactorio">Insactifactorio</option>
                    <option value="NEGATIVO">NEGATIVO</option>
                    <option value="Anormalidad celulas epiteliales">Anormalidad de celulas epiteliales</option>
                    <option value="NEGATIVO LESION INTRAEPITELIAL">NEGATIVO PARA LESION INTRAEPITELIAL O MALIGNIDAD</option>
                    <option value="ASC-US">ASC-US</option>
                    <option value="ASC-H">ASC-H</option>
                    <option value="L-SIL">LSIL</option>
                    <option value="HSIL">HSIL</option>
                </select>
            </div>
            
        </div>
    <?php else: ?>
        <!-- Mostrar formulario estándar para Biopsia, Citología, Intraoperatorio -->
        <div id="detalle_estudio" class="row mb-3">
            <div class="col-md-6">
                <label for="macro">Macro:</label>
                <textarea id="macro" name="macro" class="form-control"></textarea>
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="micro">Micro:</label>
                <textarea id="micro" name="micro" class="form-control"></textarea>
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="conclusion">Conclusión:</label>
                <textarea id="conclusion" name="conclusion" class="form-control"></textarea>
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" class="form-control"></textarea>
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="maligno">Maligno:</label>
                <textarea id="maligno" name="maligno" class="form-control"></textarea>
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="guardado">Guardado:</label>
                <input type="text" class="form-control" id="guardado" name="guardado">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="observacion_interna">Observación Interna:</label>
                <input type="text" class="form-control" id="observacion_interna" name="observacion_interna">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="recibe">Recibe:</label>
                <input type="text" class="form-control" id="recibe" name="recibe">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="tacos">Tacos:</label>
                <input type="text" class="form-control" id="tacos" name="tacos">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="diagnostico_presuntivo">Diagnóstico:</label>
                <input type="text" class="form-control" id="diagnostico_presuntivo" name="diagnostico_presuntivo">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="tecnicas">Técnicas:</label>
                <input type="text" class="form-control" id="tecnicas" name="tecnicas">
                <p></p>
            </div>
            <!--div class="col-md-6">
                <label for="material">Material:</label>
                <input type="text" class="form-control" id="material" name="material" placeholder="Material" >
            </div-->
        </div>
    <?php endif; ?>
</form>


<script>
$(document).ready(function() {
    $('.select2').select2({
        templateSelection: formatState,
        dropdownParent: $('#editModal'),
        closeOnSelect: false, // Evitar que se cierre después de seleccionar
        dropdownCssClass: "bigdrop", // Aplicar clase CSS para hacer que el dropdown sea más alto
        width: '100%'
    });

    // Ajuste para el menú desplegable en Select2
    $('.select2-container--bootstrap').on('select2:open', function (e) {
        var $dropdown = $(this).siblings('.select2-dropdown');
        var $selection = $(this).find('.select2-selection--multiple');
        var placeholderHeight = $selection.next('.select2-container').find('.select2-selection__rendered').outerHeight();

        // Ajusta la posición del menú desplegable según la posición de la selección y el placeholder
        var dropdownTop = $selection.offset().top + placeholderHeight - $(window).scrollTop() + $selection.outerHeight() + 10;

        // Ajuste adicional para mantener el menú justo debajo del input
        $dropdown.css({
            top: dropdownTop
        });

        // Evitar que se cierre automáticamente después de abrir
        $dropdown.off('mousedown.select2');
        $dropdown.on('mousedown.select2', function (event) {
            event.stopPropagation();
        });
    });

    $('.select2').on('select2:open', function (e) {
        var $dropdown = $('.select2-dropdown');
        var $selection = $('.select2-selection--multiple');
        var placeholderHeight = $selection.next('.select2-container').find('.select2-selection__rendered').outerHeight();

        // Ajusta la posición del menú desplegable según la posición de la selección y el placeholder
        var dropdownTop = $selection.offset().top + placeholderHeight - $(window).scrollTop() + $selection.outerHeight() + 10;

        // Ajuste adicional para mantener el menú justo debajo del input
        $dropdown.css({
            top: dropdownTop
        });

        // Evitar que se cierre automáticamente después de abrir
        $dropdown.off('mousedown.select2');
        $dropdown.on('mousedown.select2', function (event) {
            event.stopPropagation();
        });
    });

    // Función para contar y actualizar el placeholder
    function updatePlaceholder($select) {
        var selectedCount = $select.select2('data').length;
        if (selectedCount > 3) {
            $select.next('.select2-container').find('.select2-selection__rendered').attr('title', 'Más de 3 opciones seleccionadas');
            $select.next('.select2-container').find('.select2-selection__rendered').html('Más de 3 opciones seleccionadas');
        } else {
            $select.next('.select2-container').find('.select2-selection__rendered').attr('title', '');
            var selectedText = $select.select2('data').map(function(option) {
                return '<span class="select2-selection__choice">' + option.text + '<span class="select2-selection__choice__remove" title="Eliminar" data-select2-id="' + option.id + '">×</span></span>';
            }).join('');
            $select.next('.select2-container').find('.select2-selection__rendered').html(selectedText);
        }
    }

    // Evento para actualizar el placeholder al seleccionar/deseleccionar opciones
    $('.select2').on('select2:select select2:unselect', function (e) {
        updatePlaceholder($(this));
        // Forzar la apertura del menú desplegable después de actualizar el placeholder
        $(this).next('.select2-container').find('.select2-selection').trigger('click');
    });

    // Evento para eliminar una opción al hacer clic en la "x"
    $('.select2-container').on('click', '.select2-selection__choice__remove', function() {
        var $select = $(this).closest('.select2-container').prev('.select2');
        var id = $(this).attr('data-select2-id');
        $select.find('option[value="' + id + '"]').prop('selected', false);
        $select.trigger('change');
        updatePlaceholder($select);
    });

    // Llamar a updatePlaceholder inicialmente para configurar el placeholder inicial
    $('.select2').each(function() {
        updatePlaceholder($(this));
    });

    // Personalizar la apariencia de los elementos seleccionados
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $('<span>' + state.text + '</span>');
        return $state;
    };
});

</script>





