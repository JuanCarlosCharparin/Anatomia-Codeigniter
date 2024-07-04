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
    <p></p>

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

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="servicio" class="form-label">Servicio:</label>
            <?= $estudio['servicio']; ?>
        </div>
        <div class="col-md-6">
            <label for="medico" class="form-label">Profesional solicitante:</label>
            <?= $estudio['medico']; ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tipo_estudio" class="form-label">Tipo de estudio:</label>
            <select id="tipo_estudio" name="tipo_estudio" class="form-control">
                <option value="Biopsia" <?= $estudio['tipo_estudio'] == 'Biopsia' ? 'selected' : '' ?>>Biopsia</option>
                <option value="Citologia" <?= $estudio['tipo_estudio'] == 'Citologia' ? 'selected' : '' ?>>Citologia</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="diagnostico" class="form-label">Diagnóstico:</label>
            <input type="text" class="form-control" id="diagnostico" name="diagnostico" value="<?= $estudio['diagnostico'] ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="fecha_carga" class="form-label">Fecha de carga:</label>
            <input type="text" class="form-control" id="fecha_carga" name="fecha_carga" value="<?= $estudio['fecha_carga'] ?>">
        </div>
        <div class="col-md-6">
            <label for="estado" class="form-label">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= $estudio['estado'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="macro">Macro:</label>
        <textarea id="macro" name="macro" class="form-control"><?= $estudio['macro'] ?? '' ?></textarea>
    </div>
</form>




