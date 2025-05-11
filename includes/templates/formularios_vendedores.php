<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value=<?php echo s($vendedor->nombre); ?>>

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value=<?php echo s($vendedor->apellido); ?>>
</fieldset>

<fieldset>
    <legend>Información De Contacto</legend>

    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="6861234567" value=<?php echo s($vendedor->telefono); ?>>

    <label for="email">E-mail</label>
    <input type="text" id="email" name="vendedor[email]" placeholder="ejemplo@correo.com" value=<?php echo s($vendedor->email); ?>>

</fieldset>