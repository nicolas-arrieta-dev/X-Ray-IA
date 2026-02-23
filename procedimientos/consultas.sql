DELIMITER //
-- VERIFICAR USUARIO
DROP PROCEDURE IF EXISTS verificar_usuario//
CREATE PROCEDURE verificar_usuario(
    IN p_id VARCHAR(100),
    IN p_contrasena VARCHAR(100)
)
BEGIN
    SELECT *
    FROM empleado
    WHERE Cedula = p_id AND Password = p_contrasena;
END//
-- CONSULTAR EMPLEADO
DROP PROCEDURE IF EXISTS Consultar_empleado//
CREATE PROCEDURE Consultar_empleado(ide varchar(100))
BEGIN
SELECT *
FROM empleado
WHERE Cedula = ide;
END//

-- MOSTRAR TODO CATEGORIA
DROP PROCEDURE IF EXISTS Mostrar_todo_categoria//
CREATE PROCEDURE Mostrar_todo_categoria()
BEGIN
SELECT *
FROM categoria;
END//

-- MOSTRAR TODO ZONA
DROP PROCEDURE IF EXISTS Mostrar_todo_zona//
CREATE PROCEDURE Mostrar_todo_zona()
BEGIN
SELECT *
FROM zona;
END//

-- MOSTRAR TODO RADIOGRAFIA
DROP PROCEDURE IF EXISTS Mostrar_todo_radiografia//
CREATE PROCEDURE Mostrar_todo_radiografia()
BEGIN
SELECT 
    r.Archivo_radiografia,
    r.Id_radiografia AS ID,
    r.Fecha_hora AS "Fecha y hora",
    r.Observaciones,
    z.Nombre_zona AS Zona,
    c.Nombre_categoria AS Categoria,
    CONCAT(e.Nombre, ' ', e.Apellido) AS nombre_empleado,
    p.Cedula_Paciente AS "Cedula paciente",
    p.Fecha_nacimiento,
    CONCAT(p.Nombres, ' ', p.Apellidos) AS "Nombre completo",
    p.Genero
FROM 
    radiografia r
INNER JOIN zona z ON r.Id_zona = z.Id_zona
INNER JOIN categoria c ON r.Id_categoria = c.Id_categoria
INNER JOIN empleado e ON r.Id_empleado = e.Cedula
INNER JOIN paciente p ON r.Id_paciente = p.Id_paciente
WHERE r.EstadoActivo = 1
ORDER BY r.Fecha_hora DESC;
END//

-- CONSULTAR RADIOGRAFIA
DROP PROCEDURE IF EXISTS Consultar_radiografia//
CREATE PROCEDURE Consultar_radiografia(ide varchar(100))
BEGIN
SELECT 
    r.Archivo_radiografia,
    r.Id_radiografia AS ID,
    r.Fecha_hora AS "Fecha y hora",
    r.Observaciones,
    z.Nombre_zona AS Zona,
    c.Nombre_categoria AS Categoria,
    CONCAT(e.Nombre, ' ', e.Apellido) AS nombre_empleado,
    p.Cedula_Paciente AS "Cedula paciente",
    p.Id_paciente,
    p.Fecha_nacimiento,
    CONCAT(p.Nombres, ' ', p.Apellidos) AS "Nombre completo",
    p.Genero
FROM 
    radiografia r
INNER JOIN zona z ON r.Id_zona = z.Id_zona
INNER JOIN categoria c ON r.Id_categoria = c.Id_categoria
INNER JOIN empleado e ON r.Id_empleado = e.Cedula
INNER JOIN paciente p ON r.Id_paciente = p.Id_paciente
WHERE r.Id_radiografia = ide;

END//

-- MOSTRAR TODO PATOLOGIA
DROP PROCEDURE IF EXISTS Mostrar_todo_patologia//
CREATE PROCEDURE Mostrar_todo_patologia()
BEGIN
SELECT * FROM patologia;
END//

-- ELIMINAR PATOLOGIA
DROP PROCEDURE IF EXISTS Eliminar_patologia//
CREATE PROCEDURE Eliminar_patologia (
    IN p_Id_patologia varchar(100)
)
BEGIN
    DELETE FROM patologia
    WHERE Id_patologia = p_Id_patologia;
END//

-- MOSTRAR TODO DIAGNOSTICO
DROP PROCEDURE IF EXISTS Mostrar_todo_diagnostico//
CREATE PROCEDURE Mostrar_todo_diagnostico()
BEGIN
SELECT 
    d.Id_diagnostico,
    d.Descripcion,
    d.Nivel_gravedad,
    d.Porcentaje_confianza_IA,
    d.Tipo_Fractura_IA,
    d.Fecha_hora,
    r.Fecha_hora AS Fecha_radiografia,
    pa.Nombres AS Nombre_paciente,
    pa.Apellidos AS Apellido_paciente,
	z.Nombre_zona AS Zona_radiografiada,
    p.Nombre_patologia
    
FROM diagnostico d
INNER JOIN radiografia r ON d.Id_radiografia = r.Id_radiografia
INNER JOIN zona z ON r.Id_zona = z.Id_zona
INNER JOIN patologia p ON d.Id_patologia = p.Id_patologia
INNER JOIN paciente pa ON r.Id_paciente = pa.Id_paciente;

END//

-- CONSULTAR DIAGNOSTICO
DROP PROCEDURE IF EXISTS Consultar_Diagnostico//
CREATE PROCEDURE Consultar_Diagnostico(in ide varchar(100))
BEGIN
SELECT * from diagnostico WHERE id_diagnostico = ide;
END//

-- CONSULTAR ARCHIVO RADIOGRAFIA
DROP PROCEDURE IF EXISTS Consultar_ArchivoRadiografia//
CREATE PROCEDURE Consultar_ArchivoRadiografia(in p_Id_radiografia varchar(100))
BEGIN
SELECT Archivo_Radiografia FROM radiografia WHERE Id_radiografia = p_Id_radiografia;
END//

-- CONSULTAR PACIENTE
DROP PROCEDURE IF EXISTS Consultar_Paciente//
CREATE PROCEDURE Consultar_Paciente(in p_Id_paciente varchar(100))
BEGIN
SELECT * FROM paciente WHERE Id_paciente = p_Id_paciente;
END