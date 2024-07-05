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
        <div class="col-md-6">
            <label for="material" class="form-label">Material:</label>
            <?= $estudio['material']; ?>
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
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="estado" class="form-label">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= $estudio['estado'] ?>">
        </div>
    </div>
    <p></p>
    <hr>

    <!-- Mostrar formulario específico para Pap -->
    <?php if ($estudio['tipo_estudio_id'] == 3): ?>
        <div id="pap_estudio" action="<?= site_url('biopsia/adjuntar_detalle') ?>" method="post" class="row mb-3">
            <div class="col-md-6">
                <label for="estado_especimen">Estado Especimen:</label>
                <input type="text" class="form-control" id="estado_especimen" name="estado_especimen" placeholder="Estado Especimen">
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celulas_pavimentosas">Celulas Pavimentosas:</label>
                <input type="text" class="form-control" id="celulas_pavimentosas" name="celulas_pavimentosas" placeholder="Celulas Pavimentosas" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celulas_cilindricas">Celulas Cilindricas:</label>
                <input type="text" class="form-control" id="celulas_cilindricas" name="celulas_cilindricas" placeholder="Celulas Cilindricas" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="valor_hormonal">Valor Hormonal:</label>
                <input type="text" class="form-control" id="valor_hormonal" name="valor_hormonal" placeholder="Valor Hormonal" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="fecha_lectura">Fecha Lectura:</label>
                <input type="date" class="form-control" id="fecha_lectura" name="fecha_lectura" placeholder="Fecha Lectura" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="valor_hormonal_HC">Valor Hormonal HC:</label>
                <input type="text" class="form-control" id="valor_hormonal_HC" name="valor_hormonal_HC" placeholder="Valor Hormonal HC">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_reactivos">Cambios Reactivos:</label>
                <input type="text" class="form-control" id="cambios_reactivos" name="cambios_reactivos" placeholder="Cambios Reactivos">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_asoc_celula_pavimentosa">Cambios Asociados a Célula Pavimentosa:</label>
                <input type="text" class="form-control" id="cambios_asoc_celula_pavimentosa" name="cambios_asoc_celula_pavimentosa" placeholder="Cambios Asociados a Célula Pavimentosa" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="cambios_celula_glandulares">Cambios en Células Glandulares:</label>
                <input type="text" class="form-control" id="cambios_celula_glandulares" name="cambios_celula_glandulares" placeholder="Cambios en Células Glandulares">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="celula_metaplastica">Célula Metaplástica:</label>
                <input type="text" class="form-control" id="celula_metaplastica" name="celula_metaplastica" placeholder="Célula Metaplástica" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="otras_neo_malignas">Otras Neoplasias Malignas:</label>
                <input type="text" class="form-control" id="otras_neo_malignas" name="otras_neo_malignas" placeholder="Otras Neoplasias Malignas">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="toma">Toma:</label>
                <input type="text" class="form-control" id="toma" name="toma" placeholder="Toma" >
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="recomendaciones">Recomendaciones:</label>
                <input type="text" class="form-control" id="recomendaciones" name="recomendaciones" placeholder="Recomendaciones">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="microorganismos">Microorganismos:</label>
                <input type="text" class="form-control" id="microorganismos" name="microorganismos" placeholder="Microorganismos">
                <p></p>
            </div>
            <p></p>
            <div class="col-md-6">
                <label for="resultado">Resultado:</label>
                <input type="text" class="form-control" id="resultado" name="resultado" placeholder="Resultado" >
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
                <input type="text" class="form-control" id="guardado" name="guardado" placeholder="Guardado">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="observacion_interna">Observación Interna:</label>
                <input type="text" class="form-control" id="observacion_interna" name="observacion_interna" placeholder="Observación Interna">
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="recibe">Recibe:</label>
                <input type="text" class="form-control" id="recibe" name="recibe" placeholder="Recibe" >
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="tacos">Tacos:</label>
                <input type="text" class="form-control" id="tacos" name="tacos" placeholder="Tacos" >
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="diagnostico_presuntivo">Diagnóstico:</label>
                <input type="text" class="form-control" id="diagnostico_presuntivo" name="diagnostico_presuntivo" placeholder="Diagnóstico" >
                <p></p>
            </div>
            <div class="col-md-6">
                <label for="tecnicas">Técnicas:</label>
                <input type="text" class="form-control" id="tecnicas" name="tecnicas" placeholder="Técnicas" >
                <p></p>
            </div>
            <!--div class="col-md-6">
                <label for="material">Material:</label>
                <input type="text" class="form-control" id="material" name="material" placeholder="Material" >
            </div-->
        </div>
    <?php endif; ?>
</form>

